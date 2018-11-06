<?php

namespace Pho\GraphJS\Lib;

use GuzzleHttp\Client;
use Pho\GraphJS\GraphJS;
use Psr\Http\Message\ResponseInterface;

class ApiCall
{
    private $graphJS;
    private $client;

    public function __construct(GraphJS $graphJS, Client $client)
    {
        $this->graphJS = $graphJS;
        $this->client = $client;
    }

    public function call($path, array $args = []): ResponseInterface
    {
        $args = [
            'public_id' => $this->graphJS->getPublicId(),
        ] + $args;
        $uri = $this->graphJS->getHost() . '/' . $path . '?' . http_build_query($args);
        $response = $this->client->request('GET', $uri);

        return $response;
    }
}
