<?php

namespace Component\Controller;

use Component\Router;
use Component\Http\Request;
use Component\DependencyInjection\Container;

class ControllerResolver
{
    const SEPARATOR = '::';
    const SERVICE_NAME = 'serviceName';
    const CLASS_NAME = 'className';
    const METHOD_NAME = 'methodName';

    private $router;

    public function __construct(Router $router, Container $container)
    {
        $this->router = $router;
        $this->container = $container;
    }

    public function resolve(Request $request)
    {
        $requestUri = $request->getRequestUri();
        $controller = $this->router->getController($requestUri);

        $controllerParams = $this->getControllerParams($controller);

        $this->container->inject($controllerParams[self::SERVICE_NAME], $controllerParams[self::CLASS_NAME]);

        $response = call_user_func(
            array(
                $this->container->get($controllerParams[self::SERVICE_NAME]),
                $controllerParams[self::METHOD_NAME],
            )
        );

        return  $response;
    }

    public function getControllerParams(string $controller)
    {
        $className = substr($controller, 0, strpos($controller, self::SEPARATOR));
        $methodName = substr($controller, strpos($controller, self::SEPARATOR) + strlen(self::SEPARATOR));
        $serviceName = strtolower(substr($className, strrpos($className, '\\') + 1));

        return array(
            self::CLASS_NAME => $className,
            self::METHOD_NAME => $methodName,
            self::SERVICE_NAME => $serviceName,
        );
    }
}
