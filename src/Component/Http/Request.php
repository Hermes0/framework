<?php

namespace Component\Http;

class Request
{
    private static $request;

    private $requestUri;
    private $requestMethod;

    private function __construct()
    {
        $this->requestUri = $_SERVER['REQUEST_URI'];
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }

    public static function getRequest()
    {
        if (empty(self::$request)) {
            self::$request = new self();
        }

        return self::$request;
    }

    public function getRequestUri()
    {
        return $this->requestUri;
    }

    public function getRequestMethod()
    {
        return $this->requestMethod;
    }
}
