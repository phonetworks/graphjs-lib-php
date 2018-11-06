<?php

namespace Pho\GraphJS;

use DI\ContainerBuilder;
use Pho\GraphJS\Lib\LoginCall;

class GraphJS
{
    protected $publicId;

    protected $host = 'https://build.phonetworks.com';

    protected $sessionId;

    protected $container;

    public function __construct($publicId, $options = [])
    {
        $this->publicId = $publicId;
        $this->host = $options['host'] ?? $this->host;

        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            GraphJS::class => $this,
        ]);
        $this->container = $builder->build();
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPublicId()
    {
        return $this->publicId;
    }

    public function setSession($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function login($username, $password)
    {
        $loginCall = $this->container->get(LoginCall::class);

        return $loginCall->call($username, $password);
    }
}
