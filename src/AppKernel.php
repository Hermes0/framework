<?php

use Component\Http\Request;
use Component\DependencyInjection\Container;
use Component\ConfigLoader\YamlLoader;

class AppKernel
{
    private $container;

    public function __construct()
    {
        $this->container = new Container(new YamlLoader(__DIR__.'../../app/config/service.yml'));
    }

    public function handle(Request $request)
    {
        $resolver = $this->container->get('controller.resolver');
        $response = $resolver->resolve($request);

        return $response;
    }
}
