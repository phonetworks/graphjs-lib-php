<?php

namespace Pho\GraphJS;

class GraphJSConfig
{
    const DEFAULT_HOST = 'https://build.phonetworks.com';

    private $publicId;

    private $host = self::DEFAULT_HOST;

    private $sessionId;

    public function __construct($options = [])
    {
        if (isset($options['public_id'])) {
            $this->publicId = $options['public_id'];
        }
        if (isset($options['host'])) {
            $this->host = $options['host'];
        }
        if (isset($options['session_id'])) {
            $this->host = $options['session_id'];
        }
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    public function getPublicId()
    {
        return $this->publicId;
    }

    public function setPublicId($publicId)
    {
        $this->publicId = $publicId;

        return $this;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }

    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }
}
