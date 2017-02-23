<?php
namespace Phwoolcon\Tests\Integration;

use Phwoolcon\Config;
use Phwoolcon\Mailer;
use Phwoolcon\Queue;
use Phwoolcon\Tests\Helper\TestCase;

class MailerTest extends TestCase
{
    protected static $smtpPortReady;

    public function setUp()
    {
        parent::setUp();
        Queue::register($this->di);
    }

    public function tearDown()
    {
        // Enable mailer
        Config::set('mail.enabled', true);
        // Set async mode off
        Config::set('mail.async', false);
        Mailer::register($this->di);
        parent::tearDown();
    }

    protected function skipIfSmtpPortNotReady()
    {
        $host = Config::get('mail.smtp_host');
        $port = Config::get('mail.smtp_port');
        if (static::$smtpPortReady === null) {
            if ($fp = @stream_socket_client("tcp://{$host}:{$port}", $errNo, $errStr, 1)) {
                static::$smtpPortReady = true;
                fclose($fp);
            } else {
                static::$smtpPortReady = false;
            }
        }
        if (!static::$smtpPortReady) {
            $skipMessage = <<<EOT
SMTP server not ready on {$host}:{$port}, you may need to instal postfix, or use a real SMTP server.
I use smtp-sink (a postfix component) to run a SMTP test server:
smtp-sink -d "%d.%H.%M.%S" localhost:2500 1000
EOT;

            $this->markTestSkipped($skipMessage);
        }
    }

    public function testDisableMailer()
    {
        // Disable mailer
        Config::set('mail.enabled', false);
        Mailer::register($this->di);

        $to = ['john@domain.com' => 'John Doe'];
        $subject = 'Hello World';
        $body = 'Foo bar';

        $result = Mailer::send($to, $subject, $body);
        $this->assertEquals(0, $result);
    }

    public function testSendingEmailAsynchronously()
    {
        $this->skipIfSmtpPortNotReady();

        // Clear db queue
        /* @var \Phwoolcon\Queue\Adapter\DbQueue\Connection $dbQueue */
        $dbQueue = Queue::connection('async_email_sending')->getConnection();
        $dbQueue->getWriteConnection()->delete($dbQueue->getSource());

        $this->assertEquals(0, $dbQueue::count());

        // Prepare queue listener
        $listener = new Queue\Listener();

        // Set async mode on
        Config::set('mail.async', true);
        Mailer::register($this->di);

        $to = ['to@domain.com' => 'John Doe'];
        $subject = 'Hello World';
        $body = 'Foo bar';

        // Send a email, asynchronously
        $result = Mailer::send($to, $subject, $body);
        $this->assertEquals(1, $result);

        // The email should be in the queue
        $this->assertEquals(1, $dbQueue::count());

        // Pop the queue to send the mail
        $popResult = $listener->pop('async_email_sending', null, 0, 0, 1);
        $this->assertEquals($popResult::STATUS_SUCCESS, $popResult->getStatus());

        // Verify the job payload
        $job = $popResult->getJob();
        $this->assertInstanceOf(Queue\Adapter\JobInterface::class, $job);

        list($worker, $data) = array_values(json_decode($job->getRawBody(), true));
        $this->assertEquals([Mailer::class, 'handleQueueJob'], $worker);
        list($popTo, $popSubject, $popBody) = $data;
        $this->assertEquals($to, $popTo);
        $this->assertEquals($subject, $popSubject);
        $this->assertEquals($body, $popBody);

        // Now the queue should be empty
        $this->assertEquals(0, $dbQueue::count());
    }

    public function testSendingEmailSynchronously()
    {
        $this->skipIfSmtpPortNotReady();

        // Set async mode off
        Config::set('mail.async', false);
        Mailer::register($this->di);

        $to = ['john@domain.com' => 'John Doe'];
        $subject = 'Hello World';
        $body = 'Foo bar';

        // Send a email, synchronously
        $result = Mailer::send($to, $subject, $body);
        $this->assertEquals(1, $result);

        // Send to multiple users, synchronously
        $to = ['john@domain.com' => 'John Doe', 'jane@domain.com' => 'Jane Doe'];
        $result = Mailer::send($to, $subject, $body, Mailer::CONTENT_TYPE_TEXT);
        $this->assertEquals(2, $result);
    }

    public function testAttachmentsAndEmbeds()
    {
        $this->skipIfSmtpPortNotReady();

        // Set async mode off
        Config::set('mail.async', false);
        Mailer::register($this->di);

        $to = ['john@domain.com' => 'John Doe'];
        $subject = 'Hello World';

        // Send email with attachment in data
        $body = [
            'body' => 'Foo bar',
            'attach' => [
                'data' => 'Foo text',
                'file_name' => 'foo.txt',
                'file_type' => 'text/plain',
            ],
        ];

        $result = Mailer::send($to, $subject, $body);
        $this->assertEquals(1, $result);

        // Send email with attachment in file path
        $body = [
            'body' => 'Foo bar',
            'attach' => [
                'path' => __FILE__,
            ],
        ];

        $result = Mailer::send($to, $subject, $body);
        $this->assertEquals(1, $result);

        // Send email with attachment in file path
        $body = [
            'body' => 'Foo bar',
            'attach' => [
                'path' => __FILE__,
            ],
        ];

        $result = Mailer::send($to, $subject, $body);
        $this->assertEquals(1, $result);

        // Send email with embed media
        $body = [
            'body' => 'Foo bar <img src="%img1%">',
            'embed' => [
                'img1' => __FILE__,
            ],
        ];

        $result = Mailer::send($to, $subject, $body);
        $this->assertEquals(1, $result);
    }
}
