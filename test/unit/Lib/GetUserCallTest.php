<?php

namespace Pho\GraphJS\Lib;

use GuzzleHttp\Client;
use Pho\GraphJS\GraphJSConfig;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GetUserCallTest extends TestCase
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

    public function test_call_returns_response_data_when_failed_to_get_user()
    {
        $responseContent = [ 'success' => false, 'reason' => 'Some message' ];
        $this->stream->expects($this->any())
            ->method('getContents')
            ->will($this->returnValue(json_encode($responseContent)));
        $this->apiCall->expects($this->once())
            ->method('call')
            ->will($this->returnValue($this->response));
        $getUserCall = new GetUserCall($this->graphjsConfig, $this->apiCall);

        $this->assertEquals($responseContent, $getUserCall->call());
    }

    public function test_call_returns_response_data_and_sets_session_when_success_to_get_user()
    {
        $responseContent = [ 'success' => true, 'user' => [] ];
        $this->stream->expects($this->any())
            ->method('getContents')
            ->will($this->returnValue(json_encode($responseContent)));
        $this->apiCall->expects($this->once())
            ->method('call')
            ->will($this->returnValue($this->response));
        $this->graphjsConfig->expects($this->once())
            ->method('setSessionId');
        $getUserCall = new GetUserCall($this->graphjsConfig, $this->apiCall);

        $this->assertEquals($responseContent, $getUserCall->call());
    }
}
