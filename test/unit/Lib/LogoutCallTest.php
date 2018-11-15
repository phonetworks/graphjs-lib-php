<?php

namespace Pho\GraphJS\Lib;

use GuzzleHttp\Client;
use Pho\GraphJS\GraphJSConfig;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class LogoutCallTest extends TestCase
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

    public function test_call_returns_response_data_for_failed_logout()
    {
        $responseContent = [ 'success' => false, 'reason' => 'Some message' ];
        $this->stream->expects($this->any())
            ->method('getContents')
            ->will($this->returnValue(json_encode($responseContent)));
        $this->apiCall->expects($this->once())
            ->method('call')
            ->will($this->returnValue($this->response));
        $logoutCall = new LogoutCall($this->graphjsConfig, $this->apiCall);

        $this->assertEquals($responseContent, $logoutCall->call());
    }

    public function test_call_returns_response_data_and_removes_session_for_successful_logout()
    {
        $responseContent = [ 'success' => true ];
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
        $this->graphjsConfig->expects($this->once())
            ->method('setSessionId');
        $this->graphjsConfig->expects($this->once())
            ->method('setResponseId');
        $logoutCall = new LogoutCall($this->graphjsConfig, $this->apiCall);

        $this->assertEquals($responseContent, $logoutCall->call());
    }
}
