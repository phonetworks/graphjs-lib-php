<?php

namespace Pho\GraphJS\Lib;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Pho\GraphJS\Exception\GraphJSException;
use Pho\GraphJS\GraphJSConfig;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ApiCallTest extends TestCase
{
    private $graphjsConfig;
    private $client;
    private $response;

    public function setUp()
    {
        $this->graphjsConfig = $this->createMock(GraphJSConfig::class);
        $this->client = $this->createMock(Client::class);
        $this->response = $this->createMock(ResponseInterface::class);
    }

    public function test_call_returns_response_on_success()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->response));
        $apiCall = new ApiCall($this->graphjsConfig, $this->client);
        $response = $apiCall->call('/path', [ 'param' => 'value' ]);

        $this->assertEquals($this->response, $response);
    }

    public function test_call_uses_session_if_withSession_is_true()
    {
        $sessionId = '123abc';
        $this->graphjsConfig->expects($this->atLeastOnce())
            ->method('getSessionId')
            ->will($this->returnValue($sessionId));
        $this->client->expects($this->once())
            ->method('request')
            ->will($this->returnValue($this->response));
        $apiCall = new ApiCall($this->graphjsConfig, $this->client);
        $apiCall->call('/path', [ 'param' => 'value' ], true);
    }

    public function test_call_throws_GraphJSException_when_GuzzleException_occurs()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->willThrowException(new class extends \Exception implements GuzzleException {});
        $apiCall = new ApiCall($this->graphjsConfig, $this->client);

        $this->expectException(GraphJSException::class);

        $apiCall->call('/path', []);
    }
}
