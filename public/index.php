<?php

use Engine\Router\Matcher;
use Engine\Router\RouteCollection;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

#Автозагрузка
chdir(dirname(__DIR__));
require "vendor/autoload.php";

#Получение данных запроса
$request = ServerRequestFactory::fromGlobals();

#Коллекция маршрутов
$routes = new RouteCollection();
$routes->get('home', '^/$', 'HomeController', 'actionIndex');
$routes->get('blog', '^/blog/\d+', 'BlogController', 'actionIndex');
$routes->get('catalog/view', '^/catalog/\d+/view/\d+', 'CatalogController', 'actionView');

#Сопоставления по регулярным выражениям
$matcher = new Matcher($routes);
$a = $matcher->match($request);

$response = new HtmlResponse('');
$response = $response->withAddedHeader('Header1', 'Value1');
$response = $response->withAddedHeader('Header2', 'Value12');

$emitter = new SapiEmitter();
$emitter->emit($response);

function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
echo convert(memory_get_usage(true)).' Затрачено памяти';
echo '<br>';
echo memory_get_peak_usage();