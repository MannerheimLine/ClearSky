<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Card\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Card\Domains\PatientCard;
use Application\EMR\PatientCard\Card\Responders\PatientCardShowResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PatientCardShowAction extends AppAction implements RequestHandlerInterface
{
    private $_patientCard;

    public function __construct(PatientCard $patientCard, PatientCardShowResponder $responder)
    {
        $this->_patientCard = $patientCard;
        $this->_responder = $responder;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $payload['genders'] = $this->_patientCard->getGenders();
        $payload['card_data'] = $this->_patientCard->get($id);
        $response = $this->_responder->respond($request, $payload);
        return $response;
    }
}
