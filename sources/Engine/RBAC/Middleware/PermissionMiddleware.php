<?php

declare(strict_types = 1);

namespace Engine\RBAC\Middleware;


use Engine\AAIS\Domains\Session;
use Engine\Database\Connectors\ConnectorInterface;
use Engine\DataStructures\StructuredResponse;
use Engine\RBAC\Domains\Permission;
use Engine\RBAC\Domains\PermissionsCollection;
use Engine\RBAC\Domains\RolesCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

class PermissionMiddleware implements MiddlewareInterface
{
    const PERMIT_MODE = 0;
    const REDIRECT_MODE = 1;
    const RESPONSE_MODE = 2;
    private $_dbConnector;

    /**
     * PermissionMiddleware constructor.
     * @param ConnectorInterface $dbConnection
     */
    public function __construct(ConnectorInterface $dbConnection)
    {
        $this->_dbConnector = $dbConnection;
    }

    /**
     * @param string $url
     * @return Permission
     */
    private function getPermission(string $url) : Permission
    {
        return PermissionsCollection::get($url);
    }

    /**
     * @param Permission $permission
     * @return bool
     */
    private function comparePermission(Permission $permission) : bool {
        $roles = (new RolesCollection($this->_dbConnector))->initRoles(Session::getId());
        return $roles->hasPermission($permission->_name);
    }

    /**
     * Возвращает модификатор, который указывает на порядок действий после проверки соответствия првиелегий
     * и пользователя
     *
     * @param Permission $permission
     * @return int
     */
    private function getMode(Permission $permission) : int {
        /**
         * Такое правило доступа возникает в случае, если проверка доступа или прав не назначено к маршруту
         */
        if ($permission->_name === 'permittedAccess'){
            return self::PERMIT_MODE;
        }else{
            /**
             * Здесь логика сранения привелегии соответствующей текущему маршруту с теми привелегиями которые доступны
             * пользоватею в соответсвии с его ролью из БД.
             */
            if ($this->comparePermission($permission)){
                return self::PERMIT_MODE;
            }else{
                /**
                 * Если проверка не пройдена и прав на доступ нет. Вернет модификатор в каком виде готовить ответ
                 */
                return $permission->_mode;
            }
        }
    }

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $url = $request->getQueryParams()['url'];
        $permission = $this->getPermission($url);
        switch ($this->getMode($permission)){
            case self::REDIRECT_MODE : return new RedirectResponse('/', 302); break;
            case self::RESPONSE_MODE :
                $response = new StructuredResponse();
                $message = $response->message($response::FAIL, $permission->_message);
                $response->failed()->incomplete('message', $message);
                return new JsonResponse($response, 401);
                break;
        }
        return $response = $handler->handle($request);
    }
}