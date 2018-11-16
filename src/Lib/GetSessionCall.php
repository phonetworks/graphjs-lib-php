<?php

namespace Pho\GraphJS\Lib;

use Pho\GraphJS\GraphJSConfig;

class GetSessionCall extends BaseCall
{
    protected $getUserCall;

    public function __construct(GraphJSConfig $graphJSConfig, ApiCall $apiCall, GetUserCall $getUserCall)
    {
        parent::__construct($graphJSConfig, $apiCall);
        $this->getUserCall = $getUserCall;
    }

    public function call()
    {
        $responseId = $this->graphJSConfig->getResponseId();

        if ($responseId) {
            return [
                'success' => true,
                'id' => $responseId,
            ];
        }

        return $this->getUserCall->call();
    }
}
