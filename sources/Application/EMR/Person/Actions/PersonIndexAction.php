<?php

declare(strict_types = 1);

namespace Application\EMR\Person\Actions;


use Application\Base\AppAction;
use Application\EMR\Person\Domains\Person;
use Application\EMR\Person\Responders\PersonIndexResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PersonIndexAction extends AppAction implements RequestHandlerInterface
{
    public function __construct(Person $person, PersonIndexResponder $responder)
    {
        $this->_person = $person;
        $this->_responder = $responder;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface {
        /**
         * Payload это такой контейнер куда помещаются данные вытащенные из Domain или объект Domain и статус
         * Можно не использовать Payload а напрямую передавать объект Person
         * Request используется для пердачи параметров
         */
        $payload = $this->_person->getPersonalData(); //return Person
        /**
         * В респондер пока не вижу смысла передавать request
         */
        $response = $this->_responder->respond($request, $payload);
        $response = $response->withAddedHeader('PersonIndexAction', 'Handled');
        return $response;
    }

}
