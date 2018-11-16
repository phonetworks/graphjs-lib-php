<?php

namespace Pho\GraphJS\Lib;

use GuzzleHttp\Client;
use Pho\GraphJS\GraphJSConfig;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GetSessionCallTest extends TestCase
{
    private $graphjsConfig;
    private $apiCall;
    private $stream;
    private $response;
    private $getUserCall;

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
        $this->getUserCall = $this->createMock(GetUserCall::class);
    }

    public function test_call_returns_data_without_making_http_request_when_response_id_is_available()
    {
        $responseId = '123';
        $response = [
            'success' => true,
            'id' => $responseId,
        ];
        $this->graphjsConfig->expects($this->any())
            ->method('getResponseId')
            ->will($this->returnValue($responseId));
        $this->getUserCall->expects($this->never())
            ->method('call');

        $getSessionCall = new GetSessionCall($this->graphjsConfig, $this->apiCall, $this->getUserCall);

        $this->assertEquals($response, $getSessionCall->call());
    }

    public function test_call_returns_data_by_making_http_request_when_response_id_is_not_available()
    {
        $responseId = '123';
        $response = [
            'success' => true,
            'id' => $responseId,
        ];
        $this->graphjsConfig->expects($this->any())
            ->method('getResponseId')
            ->will($this->returnValue(null));
        $this->getUserCall->expects($this->once())
            ->method('call')
            ->will($this->returnValue($response));

        $getSessionCall = new GetSessionCall($this->graphjsConfig, $this->apiCall, $this->getUserCall);

        $this->assertEquals($response, $getSessionCall->call());
    }
}
