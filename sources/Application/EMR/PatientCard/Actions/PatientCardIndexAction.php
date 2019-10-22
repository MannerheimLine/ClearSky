<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Domains\PatientCard;
use Application\EMR\PatientCard\Responders\PatientCardIndexResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PatientCardIndexAction extends AppAction implements RequestHandlerInterface
{
    private $_patientCard;

    public function __construct(PatientCard $patientCard, PatientCardIndexResponder $responder)
    {
        $this->_patientCard = $patientCard;
        $this->_responder = $responder;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface {
        /**
         * Payload это такой контейнер куда помещаются данные вытащенные из Domain или объект Domain и статус
         * Можно не использовать Payload а напрямую передавать объект patient_card
         * Request используется для пердачи параметров
         */
        //$id = 1;
        //$payload = $this->_patientCard->getCardData($id); //return patient_card
        /**
         * В респондер пока не вижу смысла передавать request
         */
        $response = $this->_responder->respond($request);
        $response = $response->withAddedHeader('PatientCardIndexAction', 'Handled');
        return $response;
    }

}
