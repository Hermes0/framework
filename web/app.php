<?php
/*
    Front controller
*/
ini_set('display_errors', 1);


$loader = require __DIR__.'/../vendor/autoload.php';

use Component\Http\Request;

$app = new AppKernel();
$response = $app->handle(Request::getRequest());

$response->send();