<?php

namespace Pho\GraphJS\Lib;

class GetUserCall extends BaseCall
{
    public function call()
    {
        $response = $this->apiCall->call('whoami', [], true);

        $contents = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        if ($data['success']) {
            $this->graphJSConfig->setSessionId(null);
        }

        return $data;
    }
}
