<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Domains\PatientCard;
use Application\EMR\PatientCard\Responders\PersonIndexResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PatientCardIndexAction extends AppAction implements RequestHandlerInterface
{
    public function __construct(PatientCard $person, PersonIndexResponder $responder)
    {
        $this->_person = $person;
        $this->_responder = $responder;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface {
        /**
         * Payload это такой контейнер куда помещаются данные вытащенные из Domain или объект Domain и статус
         * Можно не использовать Payload а напрямую передавать объект patient_card
         * Request используется для пердачи параметров
         */
        $id = 1;
        $payload = $this->_person->getCardData($id); //return patient_card
        /**
         * В респондер пока не вижу смысла передавать request
         */
        $response = $this->_responder->respond($request, $payload);
        $response = $response->withAddedHeader('PatientCardIndexAction', 'Handled');
        return $response;
    }

}
