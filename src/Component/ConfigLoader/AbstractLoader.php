<?php

namespace Component\ConfigLoader;

abstract class AbstractLoader
{
    protected $filename;

    public function __construct($filename = null)
    {
        $this->setFilename($filename);
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }
    abstract public function read();
}
