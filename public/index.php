<?php

use Engine\Router\Exceptions\RequestNotMatchedException;
use Engine\Router\Matcher;
use Engine\Router\RouteCollection;
use Engine\Router\Router;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

#Автозагрузка
chdir(dirname(__DIR__));
require "vendor/autoload.php";

#Коллекция маршрутов
$routes = new RouteCollection();
$routes->get('blog', '/blog/{id}', 'BlogController', 'actionIndex', ['id' => '\d+']);
$routes->get('catalog/view/details', '/catalog/{id}/view/{number}-{detail}', 'CatalogController', 'actionViewDetails', ['id' => '\d+', 'number' => '\d+', 'detail' => '\d+']);
$routes->get('catalog/view', '/catalog/{id}/view/{number}', 'CatalogController', 'actionView', ['id' => '\d+', 'number' => '\d+']);
$routes->get('catalog/show', '/catalog/{id}/show/{number}', 'CatalogController', 'actionShow', ['id' => '\d+', 'number' => '\d+']);
$routes->get('home', '/', Application\Controllers\ControllerApplication::class, 'actionIndex', []);

#Получение данных запроса
$request = ServerRequestFactory::fromGlobals();

#Сопоставления по регулярным выражениям
$matcher = new Matcher($routes);
try {
    $matches = $matcher->match($request);
}
catch (RequestNotMatchedException $e) {
    //Обработать пойманное исключение
}

#Создание маршрутизатора
$router = new Router($matches);
$response = $router->run($request);

#Добавление пост-заголовков
$response = $response->withAddedHeader('Header1', 'Value1');
$response = $response->withAddedHeader('Header2', 'Value12');

#Отправка клиенту
$emitter = new SapiEmitter();
$emitter->emit($response);

#Отладочная нформация
function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
echo convert(memory_get_usage(true)).' Затрачено памяти';
echo '<br>';
echo memory_get_peak_usage();