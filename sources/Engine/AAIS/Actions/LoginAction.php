<?php

declare(strict_types = 1);

namespace Engine\AAIS\Actions;


use Engine\AAIS\Domains\Login;
use Engine\AAIS\Responders\LoginResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginAction implements RequestHandlerInterface
{
    private $_login;
    private $_responder;

    public function __construct(Login $login, LoginResponder $responder)
    {
        $this->_login = $login;
        $this->_responder = $responder;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userName = $request->getParsedBody()['login'];
        $password = $request->getParsedBody()['password'];
        $payload = $this->_login->doLogin($userName, $password);
        $response = $this->_responder->respond($request, $payload);
        return $response;
    }
}