<?php


namespace Administrator\Users\Actions;


use Application\Base\AppAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UsersShowAction extends AppAction implements RequestHandlerInterface
{

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * Должен вернуть мне JSON данные которые я верну в JS.  Там JS сам построит таблицу
         */
    }
}