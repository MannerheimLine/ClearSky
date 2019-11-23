<?php

declare(strict_types = 1);

namespace Engine\AAIS\Actions;


use Engine\AAIS\Responders\LoginIndexResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginIndexAction implements RequestHandlerInterface
{
    private $_responder;

    public function __construct(LoginIndexResponder $responder)
    {
        $this->_responder = $responder;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * Тут необходимо сделать проверку. Если пользователь уже в системе то нужно делать RedirectResponse на главную.
         * А если не то тогда отображать страницу логина.
         */
        $response = $this->_responder->respond();
        return $response;
    }
}