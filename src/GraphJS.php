<?php

namespace Pho\GraphJS;

use DI\ContainerBuilder;
use Pho\GraphJS\Lib\LoginCall;

class GraphJS
{
    private $graphJSConfig;

    private $container;

    public function __construct(GraphJSConfig $graphJSConfig)
    {
        $this->graphJSConfig = $graphJSConfig;

        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            GraphJSConfig::class => $this->graphJSConfig,
        ]);
        $this->container = $builder->build();
    }

    public function login($username, $password)
    {
        $loginCall = $this->container->get(LoginCall::class);

        return $loginCall->call($username, $password);
    }
}
