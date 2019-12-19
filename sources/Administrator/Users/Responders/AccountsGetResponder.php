<?php


namespace Administrator\Users\Responders;


use Administrator\Base\AdminResponder;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class AccountsGetResponder extends AdminResponder
{

    /**
     * @param ServerRequestInterface $request
     * @param null $payload
     * @return Response
     */
    public function respond(ServerRequestInterface $request, $payload = null): Response
    {
        return new Response\JsonResponse($payload);
    }
}