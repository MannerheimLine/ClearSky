<?php

use Application\EMR\PatientCard\Card\Actions\PatientCardAddAction;
use Application\EMR\PatientCard\Card\Actions\PatientCardEditAction;
use Application\EMR\PatientCard\Card\Actions\PatientCardGetAction;
use Application\EMR\PatientCard\Card\Actions\PatientCardIndexAction;
use Application\EMR\PatientCard\Card\Actions\PatientCardShowAction;
use Application\EMR\PatientCard\Card\Actions\PatientCardUnblockAction;
use Application\EMR\PatientCard\Card\Actions\PatientCardUpdateAction;
use Application\EMR\PatientCard\Card\Middleware\CardValidatorMiddleware;
use Application\EMR\PatientCard\Search\CardsSearch\Actions\PatientCardsSearchAction;
use Application\EMR\PatientCard\Search\DispositionSearch\Actions\DistrictSearchAction;
use Application\EMR\PatientCard\Search\DispositionSearch\Actions\StreetSearchAction;
use Application\EMR\PatientCard\Search\OrganisationsSearch\Actions\InsuranceCompanySearchAction;
use Application\EMR\PatientCard\Search\DispositionSearch\Actions\LocalitySearchAction;
use Application\EMR\PatientCard\Search\DispositionSearch\Actions\RegionSearchAction;
use Application\EMR\Talons\Actions\AmbulatoryTalonShowAction;
use Application\EMR\Talons\Actions\AmbulatoryTalonSaveAction;
use Aura\Router\RouterContainer;
use DI\ContainerBuilder;
use Engine\AAIS\Actions\LoginAction;
use Engine\AAIS\Actions\LoginIndexAction;
use Engine\AAIS\Actions\LogoutAction;
use Engine\AAIS\Middleware\AuthFormValidatorMiddleware;
use Engine\AAIS\Middleware\AuthMiddleware;
use Engine\AAIS\Middleware\LoginMiddleware;
use Engine\Base\App;
use Engine\Database\Connectors\ConnectorInterface;
use Engine\Database\Connectors\MySQLConnector;
use Engine\Database\ErrorHandlers\DBErrorsHandlerInterface;
use Engine\Database\ErrorHandlers\MySQLErrorsHandler;
use Engine\Http\MimeType\MimeTypeResolver;
use Engine\Menu\Actions\MenuIndexAction;
use Engine\Middleware\ClientIpMiddleware;
use Engine\Middleware\MemoryUsageMiddleware;
use Engine\Middleware\ModifyMiddleware;
use Engine\Middleware\ProfilerMiddleware;
use Engine\RBAC\Middleware\PermissionMiddleware;
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
$map->get('patient-card', '/app/patient-card', PatientCardIndexAction::class);
$map->get('app/patient-card/get', '/app/patient-card/get/{id}', PatientCardGetAction::class)->tokens(['id' => '\d+']);
$map->post('app/patient-card/update', '/app/patient-card/update', PatientCardUpdateAction::class);
$map->post('app/patient-card/unblock', '/app/patient-card/unblock', PatientCardUnblockAction::class);
$map->post('app/patient-card/edit', '/app/patient-card/edit', PatientCardEditAction::class);
$map->post('app/patient-card/add', '/app/patient-card/add', PatientCardAddAction::class);
$map->get('app/patient-card/show', '/app/patient-card/show/{id}', PatientCardShowAction::class)->tokens(['id' => '\d+']);
$map->post('app/patient-card/search-cards', '/app/patient-card/search-cards', PatientCardsSearchAction::class)->tokens(['searchString' => '\w+']);
$map->post('app/patient-card/search-region', '/app/patient-card/search-region', RegionSearchAction::class)->tokens(['searchString' => '\w+']);
$map->post('app/patient-card/search-district', '/app/patient-card/search-district', DistrictSearchAction::class)->tokens(['searchString' => '\w+']);
$map->post('app/patient-card/search-locality', '/app/patient-card/search-locality', LocalitySearchAction::class)->tokens(['searchString' => '\w+']);
$map->post('app/patient-card/search-street', '/app/patient-card/search-street', StreetSearchAction::class)->tokens(['searchString' => '\w+']);
$map->post('app/patient-card/search-insurance-company', '/app/patient-card/search-insurance-company', InsuranceCompanySearchAction::class)->tokens(['searchString' => '\w+']);
//$map->get('catalog/detail', '/blog/{id}/view/{number}-{detail}', Application\Blog\Action\DetailsIndexAction::class)->tokens(['id' => '\d+', 'number' => '\d+', 'detail' => '\d+']);
$map->get('login', '/login', LoginIndexAction::class);
$map->get('logout', '/logout', LogoutAction::class);
$map->post('login/do', '/login/do', LoginAction::class);
$map->post('menu/get', '/menu/get', MenuIndexAction::class);

$map->get('app/patient-card/talon', '/app/patient-card/talon/ambulatory/show/{id}', AmbulatoryTalonShowAction::class)->tokens(['id' => '\d+']);
$map->get('app/patient-card/talon/save', '/app/patient-card/talon/ambulatory/save/{id}', AmbulatoryTalonSaveAction::class)->tokens(['id' => '\d+']);

#DI Container
$definitions = [
    ConnectorInterface::class => DI\create(MySQLConnector::class),
    DBErrorsHandlerInterface::class => DI\create(MySQLErrorsHandler::class),
];
$builder = new ContainerBuilder();
$builder->addDefinitions($definitions);
$container = $builder->build();

App::initContainer($container);
App::initRouter($aura);
#Запуск
session_start();
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
    $pipeline->pipe(path('/', new MemoryUsageMiddleware()));
    $pipeline->pipe(path('/login', new LoginMiddleware()));
    $pipeline->pipe(path('/login/do', new AuthFormValidatorMiddleware()));
    $pipeline->pipe(path('/app', new AuthMiddleware(App::getDependency(ConnectorInterface::class))));
    $pipeline->pipe(path('/app', new PermissionMiddleware(App::getDependency(ConnectorInterface::class))));
    $pipeline->pipe(path('/app/patient-card/update', new CardValidatorMiddleware()));
    $pipeline->pipe(path('/app/patient-card/add', new CardValidatorMiddleware()));
    $pipeline->pipe(path('/app/control-panel', new ClientIpMiddleware()));
    $pipeline->pipe(new PathMiddlewareDecorator('/app/patient-card', new ModifyMiddleware()));
#Запуск трубопровода
    $response = $pipeline->process($request, $action);
#Добавление пост-заголовков
    $response = $response->withAddedHeader('Header1', 'Value1');
    $response = $response->withAddedHeader('Header2', 'Value12');
#Отправка клиенту
    $emitter = new SapiEmitter();
    $emitter->emit($response);
}
