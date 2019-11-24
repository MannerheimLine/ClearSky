<?php

declare(strict_types = 1);

namespace Engine\AAIS\Responders;


use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class LoginResponder
{
    public function respond(ServerRequestInterface $request, $payload) : Response
    {
        return new Response\JsonResponse($payload); //JSON
    }
}