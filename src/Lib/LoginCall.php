<?php

namespace Pho\GraphJS\Lib;

use Pho\GraphJS\GraphJSConfig;

class LoginCall
{
    private $graphJSConfig;

    private $apiCall;

    public function __construct(GraphJSConfig $graphJSConfig, ApiCall $apiCall)
    {
        $this->graphJSConfig = $graphJSConfig;
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
            $this->graphJSConfig->setSessionId($data['id']);
        }

        return $data;
    }
}
