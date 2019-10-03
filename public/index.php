<?php

use Aura\Router\RouterContainer;
use Engine\Middleware\BasicAuthMiddleware;
use Engine\Middleware\ModifyMiddleware;
use Engine\Middleware\ProfilerMiddleware;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Stratigility\Middleware\PathMiddlewareDecorator;
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

#DI Container
$definitions = [
   \Application\Blog\Domain\Inject::class => \DI\create(\Application\Blog\Domain\Inject::class),
    \Application\Blog\Domain\DataProvider::class => \DI\create(\Application\Blog\Domain\DataProvider::class),
    /*\Application\Blog\Domain\Injectable::class => \DI\factory(function (\DI\Container $c){
        return new \Application\Blog\Domain\Inject($c->get(\Application\Blog\Domain\DataProvider::class));
    }),*/
    \Application\Blog\Domain\Injectable::class => \DI\factory(function (\Application\Blog\Domain\DataProvider $provider){
        return new \Application\Blog\Domain\Inject($provider);
    }),
    //B::class => \DI\factory(function (Container $c) {
    //    return new B($c->get(A::class)->getData());
    //}),
];
$builder = new \DI\ContainerBuilder();
$builder->addDefinitions($definitions);
$container = $builder->build();



#Запуск
$request = ServerRequestFactory::fromGlobals();
$matcher = $aura->getMatcher();
$route = $matcher->match($request);

foreach ($route->attributes as $key => $val) {
    $request = $request->withAttribute($key, $val);
}

$actionClass = $route->handler;
$action = $container->get($actionClass);
/**
 * @var ResponseInterface $response
 */

#Загрузка в трубопровод
$pipeline = new MiddlewarePipe();
$pipeline->pipe(path('/', new ProfilerMiddleware()));
$pipeline->pipe(path('/', new \Engine\Middleware\ClientIpMiddleware()));
$pipeline->pipe(path('blog', new BasicAuthMiddleware()));
$pipeline->pipe(new PathMiddlewareDecorator('blog', new ModifyMiddleware()));
#Запуск трубопровода
$response = $pipeline->process($request, $action);

#Добавление пост-заголовков
$response = $response->withAddedHeader('Header1', 'Value1');
$response = $response->withAddedHeader('Header2', 'Value12');
#Отправка клиенту
$emitter = new SapiEmitter();
$emitter->emit($response);

#Отладочная информация
function convert($size)
{
    $unit = array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
echo convert(memory_get_usage(true)).' Затрачено памяти';
echo '<br>';
echo memory_get_peak_usage();