<?php

namespace Pho\GraphJS\Lib;

use Pho\GraphJS\GraphJSConfig;

abstract class BaseCall
{
    protected $graphJSConfig;

    protected $apiCall;

    public function __construct(GraphJSConfig $graphJSConfig, ApiCall $apiCall)
    {
        $this->graphJSConfig = $graphJSConfig;
        $this->apiCall = $apiCall;
    }
}
