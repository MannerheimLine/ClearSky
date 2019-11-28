<?php

declare(strict_types = 1);

namespace Engine\AAIS\Middleware;


use Engine\AAIS\Domains\Cookie;
use Engine\AAIS\Domains\Session;
use Engine\Database\Connectors\ConnectorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Задача класса:
 * - Проводить проверку авторизации пользователя в системе на защищенных страницах
 *
 * Class AuthMiddleware
 * @package Engine\AAIS\Middleware
 */
class AuthMiddleware implements MiddlewareInterface
{
    private $_dbConnector;

    public function __construct(ConnectorInterface $dbConnection)
    {
        $this->_dbConnector = $dbConnection;
    }

    /**
     * Функция создана для проверки ключа сессии с ключем БД созданным при авторизации пользователя
     *
     * @param int $id
     * @return bool
     */
    private function evaluateKey(int $id) : bool {
        $query = ("SELECT `secret_key` FROM `user_accounts` WHERE `id` = :id");
        $result = $this->_dbConnector::getConnection()->prepare($query);
        /**
             * @var \PDOStatement $result
             */
        $result->execute([
            'id' => $id
        ]);
        if ($result->rowCount() > 0){
            $key = $result->fetch()['secret_key'];
            if ($key === Session::getKey()){
                return true;
            }
        }
        return false;
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
        $uid = Session::getId();
        /**
         * Если есть сессия и в ней id пользователя, то по этому id идет поиск ключа. В случае совпадения ключа сессии с
         * ключем который был установлен при авторизации в БД, пользователь считается авторизованным иначе нет. Возможно
         * кто то другой зашел под его учетной записью, либо был выполнен им же вход н ос другого устройства
         */
        if (isset($uid)){
            if ($this->evaluateKey($uid)){
                return $response = $handler->handle($request);
            }else{
                return new RedirectResponse('/login', 302);
            }
        }
        /**
         * Если нету в сессии данных для проверки пользователя. То проверка идет с использованием куки по тому же
         * сценарию
         */
        elseif (Cookie::isValid()){
            return $response = $handler->handle($request);
        }
        /**
         * Если же нет ни сесси, ни куки, то необходимо авторизоваться
         */
        else{
            return new RedirectResponse('/login', 302);
        }
    }
}