<?php

use Administrator\Desktop\Actions\DesktopShowAction;
use Administrator\RBAC\Actions\PermissionsShowAction;
use Administrator\RBAC\Actions\RolesShowAction;
use Administrator\Users\Actions\AccountsGetAction;
use Administrator\Users\Actions\UsersIndexAction;
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
use Zend\Stratigility\MiddlewarePipe;
use function Zend\Stratigility\path;

#Автозагрузка
chdir(dirname(__DIR__));
require "vendor/autoload.php";

#Коллекция маршрутов
$aura = new RouterContainer();
$map = $aura->getMap();

$map->get('app/patient-card/get', '/app/patient-cards/{id}', PatientCardGetAction::class)->tokens(['id' => '\d+']);
$map->get('app/patient-cards/get', '/app/patient-cards', PatientCardsSearchAction::class);
$map->post('app/patient-card/add', '/app/patient-cards', PatientCardAddAction::class);
$map->put('app/patient-card/update', '/app/patient-cards/{id}', PatientCardUpdateAction::class);
$map->patch('app/patient-card/unblock', '/app/patient-cards/{id}', PatientCardUnblockAction::class);
$map->delete('app/patient-card/delete', '/app/patient-cards/{id}', PatientCardDeleteAction::class);

$map->get('app/patient-card/search-region', '/app/patient-card/regions', RegionSearchAction::class);
$map->get('app/patient-card/search-district', '/app/patient-card/districts', DistrictSearchAction::class);
$map->get('app/patient-card/search-locality', '/app/patient-card/localities', LocalitySearchAction::class);
$map->get('app/patient-card/search-street', '/app/patient-card/streets', StreetSearchAction::class);
$map->get('app/patient-card/search-insurance-company', '/app/patient-card/insurance-companies', InsuranceCompanySearchAction::class);

$map->get('app/patient-card/talon', '/app/patient-card/talons/{id}', AmbulatoryTalonShowAction::class)->tokens(['id' => '\d+']);

//$map->get('patient-card', '/app/patient-card', PatientCardIndexAction::class);
//$map->get('app/patient-card/get', '/app/patient-card/get/{id}', PatientCardGetAction::class)->tokens(['id' => '\d+']);
//$map->put('app/patient-card/update', '/app/patient-card/update', PatientCardUpdateAction::class);
//$map->post('app/patient-card/unblock', '/app/patient-card/unblock', PatientCardUnblockAction::class);
//$map->post('app/patient-card/edit', '/app/patient-card/edit', PatientCardEditAction::class);
//$map->get('app/patient-card/show', '/app/patient-card/show/{id}', PatientCardShowAction::class)->tokens(['id' => '\d+']);
//$map->post('app/patient-card/search-cards', '/app/patient-card/search-cards', PatientCardsSearchAction::class);//->tokens(['searchString' => '\w+']);
//$map->get('catalog/detail', '/blog/{id}/view/{number}-{detail}', Application\Blog\Action\DetailsIndexAction::class)->tokens(['id' => '\d+', 'number' => '\d+', 'detail' => '\d+']);
//$map->get('login', '/login', LoginIndexAction::class);
//$map->get('logout', '/logout', LogoutAction::class);
//$map->post('login/do', '/login/do', LoginAction::class);
//$map->post('menu/get', '/menu/get', MenuIndexAction::class);
//$map->get('app/patient-card/talon/save', '/app/patient-card/talon/ambulatory/save/{id}', AmbulatoryTalonSaveAction::class)->tokens(['id' => '\d+']);

/*
 * Административная часть
 */
$map->get('administrator/desktop', '/administrator/desktop', DesktopShowAction::class);
$map->get('administrator/users', '/administrator/users', UsersIndexAction::class);
$map->get('administrator/accounts/get', '/administrator/accounts/get', AccountsGetAction::class);

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

#Донастройка request для поулчения get параметров, передаваемых как массив
parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $output);
$request = $request->withAttribute('getParams', $output);
#Загрузка в трубопровод
    $pipeline = new MiddlewarePipe();
    $pipeline->pipe(path('/', new ProfilerMiddleware()));
    $pipeline->pipe(path('/', new MemoryUsageMiddleware()));
    //$pipeline->pipe(path('/login', new LoginMiddleware()));
    //$pipeline->pipe(path('/login/do', new AuthFormValidatorMiddleware()));
    //$pipeline->pipe(path('/app', new AuthMiddleware(App::getDependency(ConnectorInterface::class))));
    $pipeline->pipe(path('/administrator', new AuthMiddleware(App::getDependency(ConnectorInterface::class))));
    $pipeline->pipe(path('/app', new PermissionMiddleware(App::getDependency(ConnectorInterface::class))));
    $pipeline->pipe(path('/administrator', new PermissionMiddleware(App::getDependency(ConnectorInterface::class))));
    //$pipeline->pipe(path('/app/patient-card/update', new CardValidatorMiddleware()));
    $pipeline->pipe(path('/app/patient-card/add', new CardValidatorMiddleware()));
    //$pipeline->pipe(path('/app/control-panel', new ClientIpMiddleware()));
    //$pipeline->pipe(new PathMiddlewareDecorator('/app/patient-card', new ModifyMiddleware()));
#Запуск трубопровода
    $response = $pipeline->process($request, $action);
#Добавление пост-заголовков
    $response = $response->withAddedHeader('Header1', 'Value1');
    $response = $response->withAddedHeader('Header2', 'Value12');
#Отправка клиенту
    $emitter = new SapiEmitter();
    $emitter->emit($response);
}
