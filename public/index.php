<?php

use Aura\Router\RouterContainer;
use Engine\Middleware\ProfilerMiddleware;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Stratigility\MiddlewarePipe;

use function Zend\Stratigility\path;

#Автозагрузка
chdir(dirname(__DIR__));
require "vendor/autoload.php";

#Коллекция маршрутов
$aura = new RouterContainer();
$map = $aura->getMap();
$map->get('home', '/', Application\Blog\Action\BlogIndexAction::class);
$map->get('catalog/show', '/blog/{id}', Application\Blog\Action\CstegoryShowAction::class)->tokens(['id' => '\d+']);
$map->get('catalog/view', '/blog/{id}/view/{number}', Application\Blog\Action\CategoryIndexAction::class)->tokens(['id' => '\d+', 'number' => '\d+']);
$map->get('catalog/detail', '/blog/{id}/view/{number}-{detail}', Application\Blog\Action\DetailsIndexAction::class)->tokens(['id' => '\d+', 'number' => '\d+', 'detail' => '\d+']);

#Запуск
$request = ServerRequestFactory::fromGlobals();
$matcher = $aura->getMatcher();
$route = $matcher->match($request);

foreach ($route->attributes as $key => $val) {
    $request = $request->withAttribute($key, $val);
}

$actionClass = $route->handler;
$action = new $actionClass(); //Action
/**
 * @var ResponseInterface $response
 */

#Загрузка в трубопровод
$pipeline = new MiddlewarePipe();
$pipeline->pipe(new ProfilerMiddleware());
$pipeline->pipe(path('/', new ProfilerMiddleware()));
$pipeline->pipe(path('/blog', new \Engine\Middleware\BasicAuthMiddleware()));
$pipeline->pipe(new \Zend\Stratigility\Middleware\PathMiddlewareDecorator('/blog{id}/view/', new \Engine\Middleware\ModifyMiddleware()));
#Запуск трубопровода
$response = $pipeline->process($request, $action);

#Добавление пост-заголовков
$response = $response->withAddedHeader('Header1', 'Value1');
$response = $response->withAddedHeader('Header2', 'Value12');

#Отправка клиенту
$emitter = new SapiEmitter();
$emitter->emit($response);

#Отладочная нформация
function convert($size)
{
    $unit = array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
echo convert(memory_get_usage(true)).' Затрачено памяти';
echo '<br>';
echo memory_get_peak_usage();