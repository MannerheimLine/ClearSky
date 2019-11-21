<?php

declare(strict_types = 1);

namespace Engine\AAIS\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class AuthMiddleware
 * @package Engine\AAIS\Middleware
 */
class AuthMiddleware implements MiddlewareInterface
{

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /*
         * - Проверяем сессию если есть uid:
         * значит берем его и лезем в БД. Если в БД секретный ключ такой же как в сессии, передаем обработку далее
         * по цепочке
         * - Если в сессии нет, то идем в Cookie и там ищем нужный мне хэш + id пользователя. Сверяем хэш из куки с
         * тем что находится в БД в секрет ключе и если они совпадают идем далее по цепочке.
         * - Если в сессии нет uid и нет Cookie, а так же если хэш из Cookie не совпадает с хэшнем в БД то делаем
         * RedirectResponse на страницу авторизации
         */
    }
}