<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Card\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Card\Domains\PatientCard;
use Application\EMR\PatientCard\Card\Responders\PatientCardEditResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PatientCardEditAction extends AppAction implements RequestHandlerInterface
{
    private $_patientCard;

    public function __construct(PatientCard $patientCard, PatientCardEditResponder $responder){
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
        $id = $request->getParsedBody()['id'];
        $payload = $this->_patientCard->edit($id);
        $response = $this->_responder->respond($request, $payload);

        return $response;
    }
}