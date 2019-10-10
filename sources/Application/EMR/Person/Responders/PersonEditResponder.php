<?php


namespace Application\EMR\Person\Responders;


use Application\Base\AppResponder;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class PersonEditResponder extends AppResponder
{

    /**
     * @param ServerRequestInterface $request
     * @param null $payload
     * @return Response
     */
    public function respond(ServerRequestInterface $request, $payload = null): Response
    {
        return new Response\JsonResponse(['Data' => $payload], 201);
    }
}
