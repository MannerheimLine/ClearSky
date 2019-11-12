<?php

use Application\EMR\PatientCard\Card\Actions\PatientCardAddAction;
use Application\EMR\PatientCard\Card\Actions\PatientCardEditAction;
use Application\EMR\PatientCard\Card\Actions\PatientCardIndexAction;
use Application\EMR\PatientCard\Card\Actions\PatientCardShowAction;
use Application\EMR\PatientCard\Card\Actions\PatientCardUpdateAction;
use Application\EMR\PatientCard\Card\Middleware\CardValidatorMiddleware;
use Application\EMR\PatientCard\Search\CardsSearch\Actions\PatientCardsSearchAction;
use Application\EMR\PatientCard\Search\DispositionSearch\Actions\DistrictSearchAction;
use Application\EMR\PatientCard\Search\DispositionSearch\Actions\StreetSearchAction;
use Application\EMR\PatientCard\Search\OrganisationsSearch\Actions\InsuranceCompanySearchAction;
use Application\EMR\PatientCard\Search\DispositionSearch\Actions\LocalitySearchAction;
use Application\EMR\PatientCard\Search\DispositionSearch\Actions\RegionSearchAction;
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
$map->get('patient_card', '/patient-card', PatientCardIndexAction::class);
$map->post('patient-card/update', '/patient-card/update', PatientCardUpdateAction::class);
$map->post('patient-card/edit', '/patient-card/edit', PatientCardEditAction::class);
$map->post('patient-card/add', '/patient-card/add', PatientCardAddAction::class);
$map->get('patient-card/show', '/patient-card/show/{id}', PatientCardShowAction::class)->tokens(['id' => '\d+']);
$map->post('patient-card/search-cards', '/patient-card/search-cards', PatientCardsSearchAction::class)->tokens(['searchString' => '\w+']);
$map->post('patient-card/search-region', '/patient-card/search-region', RegionSearchAction::class)->tokens(['searchString' => '\w+']);
$map->post('patient-card/search-district', '/patient-card/search-district', DistrictSearchAction::class)->tokens(['searchString' => '\w+']);
$map->post('patient-card/search-locality', '/patient-card/search-locality', LocalitySearchAction::class)->tokens(['searchString' => '\w+']);
$map->post('patient-card/search-street', '/patient-card/search-street', StreetSearchAction::class)->tokens(['searchString' => '\w+']);
$map->post('patient-card/search-insurance-company', '/patient-card/search-insurance-company', InsuranceCompanySearchAction::class)->tokens(['searchString' => '\w+']);
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
    //$collection = new SchemeCollection('sources/Engine/Database/Creators/Schemes');
    //$tableCreator = $container->get(TableCreator::class);
    //foreach ($collection->getSchemes() as $scheme){
    //    $tableCreator->create($scheme);
    //}



    /**
     * @var ResponseInterface $response
     */
#Загрузка в трубопровод
    $pipeline = new MiddlewarePipe();
    $pipeline->pipe(path('/', new ProfilerMiddleware()));
    $pipeline->pipe(path('/', new ClientIpMiddleware()));
    $pipeline->pipe(path('/', new MemoryUsageMiddleware()));
    $pipeline->pipe(path('patient-card', new BasicAuthMiddleware()));
    $pipeline->pipe(path('patient-card/update', new CardValidatorMiddleware()));
    //$pipeline->pipe(path('patient-card/add', new CardValidatorMiddleware()));
    $pipeline->pipe(new PathMiddlewareDecorator('patient_card', new ModifyMiddleware()));
#Запуск трубопровода
    $response = $pipeline->process($request, $action);
#Добавление пост-заголовков
    $response = $response->withAddedHeader('Header1', 'Value1');
    $response = $response->withAddedHeader('Header2', 'Value12');
#Отправка клиенту
    $emitter = new SapiEmitter();
    $emitter->emit($response);
}
