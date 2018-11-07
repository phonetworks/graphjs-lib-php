<?php

namespace Pho\GraphJS\Lib;

use GuzzleHttp\Client;
use Pho\GraphJS\GraphJSConfig;
use Psr\Http\Message\ResponseInterface;

class ApiCall
{
    private $graphJSConfig;
    private $client;

    public function __construct(GraphJSConfig $graphJSConfig, Client $client)
    {
        $this->graphJSConfig = $graphJSConfig;
        $this->client = $client;
    }

    public function call($path, array $args = []): ResponseInterface
    {
        $args = [
            'public_id' => $this->graphJSConfig->getPublicId(),
        ] + $args;
        $uri = $this->graphJSConfig->getHost() . '/' . $path . '?' . http_build_query($args);
        $response = $this->client->request('GET', $uri);

        return $response;
    }
}
