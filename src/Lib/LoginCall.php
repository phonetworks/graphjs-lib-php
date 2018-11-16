<?php

namespace Pho\GraphJS\Lib;

class LoginCall extends BaseCall
{
    public function call($username, $password)
    {
        $response = $this->apiCall->call('login', [
            'username' => $username,
            'password' => $password,
        ]);

        $contents = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        if ($data['success']) {
            $cookies = $response->getHeader('Set-Cookie');
            $cookies = array_reduce($cookies, function ($acc, $cookie) {
                $keyValue = explode('=', $cookie);
                return [
                    $keyValue[0] => $keyValue[1],
                ] + $acc;
            }, []);
            if (isset($cookies['id'])) {
                $this->graphJSConfig->setSessionId($cookies['id']);
            }
            $this->graphJSConfig->setResponseId($data['id']);
        }

        return $data;
    }
}
