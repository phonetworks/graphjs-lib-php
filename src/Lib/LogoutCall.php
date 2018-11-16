<?php

namespace Pho\GraphJS\Lib;

class LogoutCall extends BaseCall
{
    public function call()
    {
        $response = $this->apiCall->call('logout', [], true);

        $contents = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        if ($data['success']) {
            $this->graphJSConfig->setResponseId(null);
            $this->graphJSConfig->setSessionId(null);
        }

        return $data;
    }
}
