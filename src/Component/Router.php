<?php

namespace Component;

use Component\ConfigLoader\AbstractLoader;

class Router
{
    private $loader;
    private $routeMap = array();

    public function __construct(AbstractLoader $loader = null)
    {
        $this->loader = $loader;
        $this->collectRoutes();
    }

    public function collectRoutes()
    {
        $this->loader->setFilename(__DIR__.'../../../app/config/routing.yml');
        $this->routeMap = $this->loader->read();
    }

    public function getController($uri)
    {
        $arrIt = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->routeMap));

        foreach ($arrIt as $sub) {
            $route = $arrIt->getSubIterator();
            if ($route['path'] === $uri) {
                $matched = iterator_to_array($route);
                break;
            }
        }

        return $matched['controller'];
    }
}
