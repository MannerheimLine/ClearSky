<?php


namespace Application\Blog\Action;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class DetailsIndexAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface$request) : ResponseInterface
    {
        $id = $request->getAttributes()['id'];
        $number = $request->getAttributes()['number'];
        $detail = $request->getAttributes()['detail'];
        $response = new JsonResponse(['id' => $id, 'number' => $number, 'detail' => $detail], 200);
        return $response;
    }

}