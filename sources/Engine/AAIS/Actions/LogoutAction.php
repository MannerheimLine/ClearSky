<?php


namespace Engine\AAIS\Actions;


use Engine\AAIS\Domains\Login;
use Engine\AAIS\Responders\LogoutResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogoutAction implements RequestHandlerInterface
{
    private $_login;
    private $_responder;

    public function __construct(Login $login, LogoutResponder $responder)
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
        $payload = $this->_login->doLogout();
        $response = $this->_responder->respond($request, $payload);
        return $response;
    }
}