<?php

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require "vendor/autoload.php";
$request = ServerRequestFactory::fromGlobals();
$path = $request->getUri()->getPath();

$response = new HtmlResponse($path);
$response = $response->withAddedHeader('Header1', 'Value1');
$response = $response->withAddedHeader('Header2', 'Value12');



$emitter = new SapiEmitter();
$emitter->emit($response);