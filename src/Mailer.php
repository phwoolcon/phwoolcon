<?php

namespace Phwoolcon;

use Phalcon\Di;
use Phwoolcon\Queue\Adapter\JobTrait;
use Swift;
use Swift_Attachment;
use Swift_Image;
use Swift_Mailer;
use Swift_Message;
use Swift_SendmailTransport;
use Swift_SmtpTransport;
use Swift_SwiftException;

class Mailer
{
    const CONTENT_TYPE_HTML = 'text/html';
    const CONTENT_TYPE_TEXT = 'text/plain';

    /**
     * @var Di
     */
    protected static $di;

    /**
     * @var static
     */
    protected static $instance;
    protected static $mailerInitialized = false;
    /**
     * @var Swift_Mailer
     */
    protected $mailerLibrary;

    protected $async = false;
    protected $enabled = false;
    /**
     * @var Queue\Adapter\DbQueue
     */
    protected $queue;
    protected $config;
    protected $sender;
    protected $logContent = true;

    protected function __construct($config)
    {
        $this->config = $config;
        $this->enabled = fnGet($config, 'enabled');
        $this->logContent = fnGet($config, 'log_content');
        $this->async = fnGet($config, 'async') && ($this->queue = Queue::connection('async_email_sending'));
        $this->sender = [fnGet($config, 'sender.address') => fnGet($config, 'sender.name')];
        switch (fnGet($config, 'driver')) {
            case 'smtp':
                $host = fnGet($config, 'smtp_host');
                $port = fnGet($config, 'smtp_port');
                $encryption = fnGet($config, 'smtp_encryption');
                $username = fnGet($config, 'smtp_username');
                $password = fnGet($config, 'smtp_password');

                $transport = new Swift_SmtpTransport($host, $port, $encryption);
                $transport->setUsername($username)->setPassword($password);
                break;
            // @codeCoverageIgnoreStart
            case 'sendmail':
                $transport = new Swift_SendmailTransport();
                break;
            default:
                throw new Swift_SwiftException('Please specify available driver in mail config');
            // @codeCoverageIgnoreEnd
        }
        $mailer = new Swift_Mailer($transport);
        $this->mailerLibrary = $mailer;
    }

    /**
     * @param array $definitions
     * @return Swift_Attachment[]
     */
    public function generateAttachments(array $definitions)
    {
        if (isset($definitions['data']) || isset($definitions['path'])) {
            $definitions = [$definitions];
        }

        $attachments = [];
        foreach ($definitions as $definition) {
            // @codeCoverageIgnoreStart
            if (is_string($definition)) {
                $definition = ['path' => $definition];
            }
            // @codeCoverageIgnoreEnd

            $filename = isset($definition['file_name']) ? $definition['file_name'] : null;
            $contentType = isset($definition['file_type']) ? $definition['file_type'] : null;
            if (isset($definition['data'])) {
                $attachments[] = new Swift_Attachment($definition['data'], $filename, $contentType);
            } elseif (isset($definition['path']) && is_file($definition['path'])) {
                $attachment = Swift_Attachment::fromPath($definition['path'], $contentType);
                $filename and $attachment->setFilename($filename);
                $attachments[] = $attachment;
            }
        }
        return $attachments;
    }

    /**
     * @param JobTrait $job
     * @param array    $payload
     */
    public static function handleQueueJob($job, array $payload)
    {
        static::$instance === null and static::$instance = static::$di->getShared('mailer');
        call_user_func_array([static::$instance, 'realSend'], $payload);
    }

    protected function log($to, $subject, $body, $contentType, $cc)
    {
        $isHtml = $contentType == static::CONTENT_TYPE_HTML;
        $fileExt = $isHtml ? '.html' : '.txt';
        $firstTo = $to;
        if (is_array($to)) {
            foreach ($to as $email => $name) {
                $firstTo = is_numeric($email) ? $name : $email;
                break;
            }
        }

        $dir = dirname($logFile = storagePath('mail/' . date('Ymd-His') . '.' . $firstTo . $fileExt));
        is_dir($dir) or mkdir($dir, 0777, true);
        $bodyText = is_array($body) ? $body['body'] : $body;
        $additionalInfo = json_encode(
            compact('to', 'subject', 'cc'),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        $isHtml and $additionalInfo = "<pre>{$additionalInfo}</pre>";
        file_put_contents($logFile, $bodyText . "\n\n" . $additionalInfo);
    }

    protected function queue($to, $subject, $body, $contentType = self::CONTENT_TYPE_TEXT, $cc = null)
    {
        $this->queue->push([static::class, 'handleQueueJob'], func_get_args());
    }

    public function realSend($to, $subject, $body, $contentType = self::CONTENT_TYPE_TEXT, $cc = null)
    {
        // Fetch body text
        $bodyText = isset($body['body']) ? $body['body'] : $body;
        $message = new Swift_Message($subject, $bodyText, $contentType);

        // Process attachments
        if (isset($body['attach'])) {
            foreach ($this->generateAttachments((array)$body['attach']) as $attachment) {
                $message->attach($attachment);
            }
        }

        // Process inline medias
        if (isset($body['embed']) && is_array($body['embed'])) {
            $placeholders = [];
            $replacements = [];
            foreach ($body['embed'] as $placeholder => $embed) {
                is_numeric($placeholder) and $placeholder = $embed;
                $contentId = $message->embed(Swift_Image::fromPath($embed));
                $placeholders[] = '%' . $placeholder . '%';
                $replacements[] = $contentId;
            }
            $bodyText = str_replace($placeholders, $replacements, $bodyText);
            $message->setBody($bodyText);
        }

        // Add receivers and sender
        $message->setTo($to);
        $cc and $message->setCc($cc);
        $message->setFrom($this->sender);

        // Send the mail
        $sent = $this->mailerLibrary->send($message);
        $this->mailerLibrary->getTransport()->stop();
        return $sent;
    }

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->remove('mailer');
        static::$instance = null;

        if (!static::$mailerInitialized) {
            static::$mailerInitialized = true;
            Swift::autoload(Swift_Mailer::class);
        }

        $di->setShared('mailer', function () {
            return new static(Config::get('mail'));
        });
    }

    /**
     * If `async` is disabled, the mail will be sent immediately (default behaviour)
     * If `async` is enabled, the mail will be pushed into queue instead, then send it by a backend process:
     * `bin/cli queue:consume async_email_sending`
     *
     * @param string|array $to   Supports 'to@domain.com', ['to@domain.com'] or ['to@domain.com' => 'Display Name']
     * @param string       $subject
     * @param string|array $body If you want to send attachment, or send embed media, please use array form:
     *                           ['body' => 'Body text', 'attach' => $attachments, 'embed' => $embed]
     *                           for the structure of $attachments, @see Mailer::generateAttachments()
     *                           for the structure of $embed, @see Mailer::realSend()
     * @param string       $contentType
     * @param string|array $cc   @see $to
     * @return int
     */
    public static function send($to, $subject, $body, $contentType = self::CONTENT_TYPE_TEXT, $cc = null)
    {
        static::$instance === null and static::$instance = static::$di->getShared('mailer');
        $mailer = static::$instance;
        $mailer->logContent and $mailer->log($to, $subject, $body, $contentType, $cc);
        if (!$mailer->enabled) {
            return 0;
        } elseif ($mailer->async && $mailer->queue) {
            $mailer->queue($to, $subject, $body, $contentType, $cc);
            return 1;
        } else {
            return $mailer->realSend($to, $subject, $body, $contentType, $cc);
        }
    }
}
