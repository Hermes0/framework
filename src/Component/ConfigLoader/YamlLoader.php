<?php

namespace Component\ConfigLoader;

class YamlLoader extends AbstractLoader
{
    public function read()
    {
        if ($this->filename) {
            $result = yaml_parse_file($this->filename);

            return $result;
        }

        return null;
    }
}
