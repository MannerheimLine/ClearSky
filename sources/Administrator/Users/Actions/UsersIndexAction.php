<?php


namespace Administrator\Users\Actions;


use Administrator\Users\Responders\UsersIndexResponder;
use Application\Base\AppAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UsersIndexAction extends AppAction implements RequestHandlerInterface
{
    public function __construct(UsersIndexResponder $responder)
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
        $response = $this->_responder->respond($request);
        return $response;
    }
}