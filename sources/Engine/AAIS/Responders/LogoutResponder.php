<?php


namespace Engine\AAIS\Responders;


use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class LogoutResponder
{
    public function respond(ServerRequestInterface $request, $payload) : Response
    {
        return new Response\JsonResponse($payload); //JSON
    }
}