<?php


namespace Application\EMR\PatientCard\Card\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Card\Domains\PatientCard;
use Application\EMR\PatientCard\Card\Responders\PatientCardAddResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PatientCardAddAction extends AppAction implements RequestHandlerInterface
{
    private $_patientCard;

    public function __construct(PatientCard $patientCard, PatientCardAddResponder $responder)
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
        $addingData = $request->getParsedBody();
        $payload = $this->_patientCard->addCardData($addingData);
        $response = $this->_responder->respond($request, $payload);

        return $response;
    }
}
