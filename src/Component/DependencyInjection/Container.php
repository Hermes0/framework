<?php

namespace Component\DependencyInjection;

use Component\ConfigLoader\AbstractLoader;

class Container
{
    private $loader;
    private $parameterBag;

    private $serviceConfig;
    private $container = array();

    public function __construct(AbstractLoader $loader)
    {
        $this->loader = $loader;
        $this->build();
    }

    public function build()
    {
        // $this->loader->setFilename
        $this->serviceConfig = $this->loader->read();
        $this->container['container'] = $this;
    }

    public function get(string $serviceName)
    {
        $serviceArguments = array();

        // serch in container if service is already instanced
        if (array_key_exists($serviceName, $this->container)) {
            return $this->container[$serviceName];
        } else {
            // build service by given name
            if (array_key_exists($serviceName, $this->serviceConfig)) {
                $serviceClass = $this->serviceConfig[$serviceName]['class'];

                // parse service parameters
                if (array_key_exists('arguments', $this->serviceConfig[$serviceName])) {
                    $serviceArguments = $this->serviceConfig[$serviceName]['arguments'];
                }

                if (count($serviceArguments) > 0) {
                    $serviceArguments = $this->buildArguments($serviceArguments);
                }

                // instace service
                $reflection = new \ReflectionClass($serviceClass);
                if (count($serviceArguments) > 0) {
                    $instance = $reflection->newInstanceArgs($serviceArguments);
                } else {
                    $instance = $reflection->newInstance();
                }

                $this->container[$serviceName] = $instance;

                return $instance;
            }
        }

        return false;
    }

    public function inject($serviceName, $className, array $params = null)
    {
        $reflection = new \ReflectionClass($className);
        $instance = $reflection->newInstance();

        $this->container[$serviceName] = $instance;
    }

    public function buildArguments($arguments)
    {
        $parsedArgumens = array();
        foreach ($arguments as $argument) {
            // service parameter is another service
            if (strpos($argument, '@') == 0) {
                $serviceName = substr($argument, 1);
                $serviceInstace = $this->get($serviceName);

                array_push($parsedArgumens, $serviceInstace);
            }
        }

        return $parsedArgumens;
    }
}
