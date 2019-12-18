<?php


namespace Administrator\RBAC\Actions;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\TextResponse;

class RolesShowAction implements RequestHandlerInterface
{


    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        //Списком вывести все роли в системе, для последующей манипуляции
        return new TextResponse('Тут будут отображаться роли');
    }
}