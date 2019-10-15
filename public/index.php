<?php

use Application\EMR\Person\Actions\PersonEditAction;
use Application\EMR\Person\Actions\PersonIndexAction;
use Aura\Router\RouterContainer;
use DI\ContainerBuilder;
use Engine\Database\Connectors\ConnectorInterface;
use Engine\Database\Connectors\MySQLConnector;
use Engine\Http\MimeType\MimeTypeResolver;
use Engine\Middleware\BasicAuthMiddleware;
use Engine\Middleware\ClientIpMiddleware;
use Engine\Middleware\MemoryUsageMiddleware;
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
$map->get('person', '/', PersonIndexAction::class);
$map->get('person/edit', '/person/edit/{id}', PersonEditAction::class)->tokens(['id' => '\d+']);
//$map->get('catalog/detail', '/blog/{id}/view/{number}-{detail}', Application\Blog\Action\DetailsIndexAction::class)->tokens(['id' => '\d+', 'number' => '\d+', 'detail' => '\d+']);

#DI Container
$definitions = [
    ConnectorInterface::class => DI\create(MySQLConnector::class),//->method('getConnection'),
];
$builder = new ContainerBuilder();
$builder->addDefinitions($definitions);
$container = $builder->build();

#Запуск
$request = ServerRequestFactory::fromGlobals();
#Решение проблем с определением типа Content Type для js/css файлов
$resolver = new MimeTypeResolver();
$resolver->resolve($request);
#Парсинг роутов
$matcher = $aura->getMatcher();
$route = $matcher->match($request);
if ($route){
    foreach ($route->attributes as $key => $val) {
        $request = $request->withAttribute($key, $val);
    }
    $actionClass = $route->handler;
    $action = $container->get($actionClass);




    //$db = $container->get(\Engine\Database\Creators\DbCreator::class);
    //$db->createDataBase('db');
    //$db->createTable('table');
    $collection = new \Engine\Database\Creators\SchemeCollection('sources/Engine/Database/Creators/Schemes');
    $tableCreator = $container->get(\Engine\Database\Creators\TableCreator::class);
    foreach ($collection->getSchemes() as $scheme){
        $tableCreator->create($scheme);
    }



    /**
     * @var ResponseInterface $response
     */
#Загрузка в трубопровод
    $pipeline = new MiddlewarePipe();
    $pipeline->pipe(path('/', new ProfilerMiddleware()));
    $pipeline->pipe(path('/', new ClientIpMiddleware()));
    $pipeline->pipe(path('/', new MemoryUsageMiddleware()));
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
}
