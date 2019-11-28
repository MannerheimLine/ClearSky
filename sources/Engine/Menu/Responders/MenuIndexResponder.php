<?php


namespace Engine\Menu\Responders;


use Zend\Diactoros\Response\JsonResponse;

class MenuIndexResponder
{
    public function respond($payload) : JsonResponse
    {
        return new JsonResponse($payload);
    }
}