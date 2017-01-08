<?php

namespace Component\Http;

class Response
{
    private $content;

    public function __construct($content = '', $status = 200, $headers = array())
    {
        $this->content = $content;
    }

    public function send()
    {
        echo $this->content;
    }
}
