<?php


namespace Administrator\Users\Actions;


use Administrator\Base\AdminAction;
use Administrator\Users\Domains\Users;
use Administrator\Users\Responders\AccountsGetResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AccountsGetAction extends AdminAction implements RequestHandlerInterface
{
    private $_users;

    public function __construct(Users $users, AccountsGetResponder $responder)
    {
        $this->_users = $users;
        $this->_responder = $responder;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $users = $this->_users->getAll();
        $response = $this->_responder->respond($request, $users);
        return $response;
    }
}