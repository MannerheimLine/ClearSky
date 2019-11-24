<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Card\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Card\Domains\PatientCard;
use Application\EMR\PatientCard\Card\Responders\PatientCardIndexResponder;
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
        $response = $this->_responder->respond($request);
        return $response;
    }

}
