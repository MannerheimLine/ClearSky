<?php

use Application\EMR\Person\Actions\PersonIndexAction;
use Aura\Router\RouterContainer;
use DI\ContainerBuilder;
use Engine\Database\Connectors\ConnectorInterface;
use Engine\Database\Connectors\MySQLConnector;
use Engine\Middleware\BasicAuthMiddleware;
use Engine\Middleware\ClientIpMiddleware;
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
$map->get('home', '/', PersonIndexAction::class);
//$map->get('catalog/detail', '/blog/{id}/view/{number}-{detail}', Application\Blog\Action\DetailsIndexAction::class)->tokens(['id' => '\d+', 'number' => '\d+', 'detail' => '\d+']);

#DI Container
$definitions = [
    ConnectorInterface::class => DI\create(MySQLConnector::class)->method('getConnection'),
];

$builder = new ContainerBuilder();
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
$pipeline->pipe(path('/', new ClientIpMiddleware()));
$pipeline->pipe(path('person', new BasicAuthMiddleware()));
$pipeline->pipe(new PathMiddlewareDecorator('person', new ModifyMiddleware()));
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