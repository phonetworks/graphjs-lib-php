<?php

namespace Pho\GraphJS;

use DI\ContainerBuilder;
use Pho\GraphJS\Lib\GetSessionCall;
use Pho\GraphJS\Lib\GetUserCall;
use Pho\GraphJS\Lib\LoginCall;
use Pho\GraphJS\Lib\LogoutCall;

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

    public function logout()
    {
        $logoutCall = $this->container->get(LogoutCall::class);

        return $logoutCall->call();
    }

    public function getUser()
    {
        $getUserCall = $this->container->get(GetUserCall::class);

        return $getUserCall->call();
    }

    public function getSession()
    {
        $getSessionCall = $this->container->get(GetSessionCall::class);

        return $getSessionCall->call();
    }
}
