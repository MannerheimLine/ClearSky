<?php

declare(strict_types = 1);

namespace Application\EMR\Person\Actions;


use Application\EMR\Person\Domains\Person;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class PersonIndexAction implements RequestHandlerInterface
{
    private $_person;

    public function __construct(Person $person)
    {
        $this->_person = $person;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface{
        $personalData = $this->_person->getPersonalData();
        $response = new JsonResponse($personalData);
        return $response;
    }

}