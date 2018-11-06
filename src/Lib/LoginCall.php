<?php

namespace Pho\GraphJS\Lib;

use Pho\GraphJS\GraphJS;

class LoginCall
{
    private $graphJS;

    private $apiCall;

    public function __construct(GraphJS $graphJS, ApiCall $apiCall)
    {
        $this->graphJS = $graphJS;
        $this->apiCall = $apiCall;
    }

    public function call($username, $password)
    {
        $response = $this->apiCall->call('login', [
            'username' => $username,
            'password' => $password,
        ]);

        $contents = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        if ($data['success']) {
            $this->graphJS->setSession($data['id']);
        }

        return $data;
    }
}
