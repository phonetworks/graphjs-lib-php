<?php

namespace Pho\GraphJS\Lib;

use GuzzleHttp\Client;
use Pho\GraphJS\GraphJSConfig;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class LoginCallTest extends TestCase
{
    private $graphjsConfig;
    private $apiCall;
    private $stream;
    private $response;

    public function setUp()
    {
        $this->graphjsConfig = $this->createMock(GraphJSConfig::class);
        $this->apiCall = $this->getMockBuilder(ApiCall::class)
            ->setConstructorArgs([$this->graphjsConfig, $this->createMock(Client::class)])
            ->setMethods(['call'])
            ->getMock();
        $this->stream = $this->createMock(StreamInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->response->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue($this->stream));
    }

    public function test_call_returns_response_data_for_failed_login()
    {
        $responseContent = [ 'success' => false, 'reason' => 'some message' ];
        $this->stream->expects($this->any())
            ->method('getContents')
            ->will($this->returnValue(json_encode($responseContent)));
        $this->apiCall->expects($this->once())
            ->method('call')
            ->will($this->returnValue($this->response));
        $loginCall = new LoginCall($this->graphjsConfig, $this->apiCall);

        $this->assertEquals($responseContent, $loginCall->call('username', 'password'));
    }

    public function test_call_returns_response_data_and_sets_session_for_successful_login()
    {
        $responseId = '1234abcd';
        $responseContent = [ 'success' => true, 'id' => $responseId ];
        $sessionId = '123';
        $setCookieHeaderValues = [ 'id=' . $sessionId ];
        $this->stream->expects($this->any())
            ->method('getContents')
            ->will($this->returnValue(json_encode($responseContent)));
        $this->response->expects($this->any())
            ->method('getHeader')
            ->with('Set-Cookie')
            ->will($this->returnValue($setCookieHeaderValues));
        $this->apiCall->expects($this->once())
            ->method('call')
            ->will($this->returnValue($this->response));
        $this->graphjsConfig->expects($this->any())
            ->method('getSessionId')
            ->will($this->returnValue($sessionId));
        $this->graphjsConfig->expects($this->any())
            ->method('getResponseId')
            ->will($this->returnValue($responseId));
        $loginCall = new LoginCall($this->graphjsConfig, $this->apiCall);

        $this->assertEquals($responseContent, $loginCall->call('username', 'password'));
        $this->assertEquals($sessionId, $this->graphjsConfig->getSessionId());
        $this->assertEquals($responseId, $this->graphjsConfig->getResponseId());
    }
}
