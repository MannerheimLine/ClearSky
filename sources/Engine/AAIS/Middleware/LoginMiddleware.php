<?php


namespace Engine\AAIS\Middleware;


use Engine\AAIS\Domains\Cookie;
use Engine\AAIS\Domains\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Задача класса:
 * - Перенаправлять авторизованного пользователя в систему если он пытается попасть на страницу авторизации
 *
 * Class LoginMiddleware
 * @package Engine\AAIS\Middleware
 */
class LoginMiddleware implements MiddlewareInterface
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
        if (Session::getId() === null){
            if (Cookie::isValid() === false){
                return $response = $handler->handle($request);
            }else{
                return new RedirectResponse('/patient-card', 302);
            }
        }else{
            return new RedirectResponse('/patient-card', 302);
        }
    }
}