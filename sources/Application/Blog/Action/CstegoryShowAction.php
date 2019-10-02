<?php


namespace Application\Blog\Action;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class CstegoryShowAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface{
        $id = $request->getAttributes()['id'];
        $response = new JsonResponse(['id' => $id], 200);
        return $response;
    }

}