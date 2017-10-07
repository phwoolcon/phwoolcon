<?php

namespace Phwoolcon\Tests\Integration\Http;

use Phwoolcon\Exception\HttpClientException;
use Phwoolcon\Http\Client;
use Phwoolcon\Tests\Helper\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        parent::setUp();
        Client::register($this->di);
        $this->client = Client::getInstance();
    }

    public function testGet()
    {
        $client = $this->client;

        $url = 'https://api.github.com/users/Fishdrowned/orgs';
        $response = Client::get($url);
        $this->assertNotEmpty($response);
        $this->assertNotEmpty($headers = $client->getLastResponseHeaders());
        $this->assertArrayHasKey('content-type', $headers);
        $this->assertEquals(200, $client->getLastResponseCode());
        $this->assertEquals($url, $client->getLastRequest()['url']);
        $this->assertEquals($response, $client->getLastResponse());

        $url = 'https://api.github.com/repos/phwoolcon/phwoolcon/issues';
        $response = Client::get($url, ['state' => 'closed']);
        $this->assertNotEmpty($response);
        $this->assertNotEmpty($headers = $client->getLastResponseHeaders());
        $this->assertArrayHasKey('content-type', $headers);
        $this->assertEquals(200, $client->getLastResponseCode());
        $this->assertEquals($url, $client->getLastRequest()['url']);
        $this->assertEquals($response, $client->getLastResponse());
    }

    public function testHead()
    {
        $client = $this->client;

        $url = 'https://api.github.com/users/Fishdrowned/orgs';
        $response = Client::head($url);
        $this->assertEmpty($response);
        $this->assertNotEmpty($headers = $client->getLastResponseHeaders());
        $this->assertArrayHasKey('content-type', $headers);
        $this->assertEquals(200, $client->getLastResponseCode());
        $this->assertEquals($url, $client->getLastRequest()['url']);
        $this->assertEquals($response, $client->getLastResponse());
    }

    public function testPost()
    {
        $client = $this->client;

        $url = 'https://api.github.com/authorizations';
        $response = Client::post($url, '{"scopes":["public_repo"]}');
        $this->assertNotEmpty($response);
        $this->assertNotEmpty($headers = $client->getLastResponseHeaders());
        $this->assertArrayHasKey('content-type', $headers);
        $this->assertEquals(401, $client->getLastResponseCode());
        $this->assertEquals($url, $client->getLastRequest()['url']);
        $this->assertEquals($response, $client->getLastResponse());
    }

    public function testCustomMethod()
    {
        $client = $this->client;

        $url = 'https://api.github.com/some-thing-that-not-exists';
        $response = Client::request($url, '', 'DELETE');
        $this->assertNotEmpty($response);
        $this->assertNotEmpty($headers = $client->getLastResponseHeaders());
        $this->assertArrayHasKey('content-type', $headers);
        $this->assertEquals(404, $client->getLastResponseCode());
        $this->assertEquals($url, $client->getLastRequest()['url']);
        $this->assertEquals($response, $client->getLastResponse());
    }

    public function testErrorAndCustomDns()
    {
        $client = $this->client;
        $options = $client->getOptions();
        $invalidIp = '192.0.2.1';
        $customDns = "api.no-this-site.dev:80:{$invalidIp}";

        ob_start();
        $stdOut = fopen('php://output', 'w');
        $client->setOptions(array_replace($options, [
            'custom_dns'   => [$customDns],
            'curl_options' => [
                CURLOPT_CONNECTTIMEOUT_MS => 100,
                CURLOPT_VERBOSE           => true,
                CURLOPT_STDERR            => $stdOut,
            ],
        ]));

        $url = 'http://api.no-this-site.dev/';
        $response = null;
        $e = null;
        try {
            $response = Client::get($url);
        } catch (\Exception $e) {
        }
        fclose($stdOut);
        $verboseInfo = ob_get_clean();
        $client->setOptions($options);

        $this->assertInstanceOf(HttpClientException::class, $e);

        $this->assertContains("Added {$customDns} to DNS cache", $verboseInfo);
        $this->assertContains("Trying {$invalidIp}...", $verboseInfo);

        $this->assertNull($response);
        $this->assertNull($client->getLastResponse());
        $this->assertEmpty($client->getLastResponseHeaders());
        $this->assertEquals($url, $client->getLastCurlInfo()['url']);
        $this->assertEquals(0, $client->getLastResponseCode());
        $this->assertEquals($url, $client->getLastRequest()['url']);
    }
}
