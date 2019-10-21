<?php


namespace Application\EMR\PatientCard\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Domains\PatientCard;
use Application\EMR\PatientCard\Responders\PatientCardUpdateResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class PatientCardUpdateAction extends AppAction implements RequestHandlerInterface
{
    private $_patientCard;

    public function __construct(PatientCard $patientCard, PatientCardUpdateResponder $responder)
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
        $updatingData = $request->getParsedBody();
        $payload = $this->_patientCard->updateCardData($updatingData);
        $response = $this->_responder->respond($request, $payload);

        return $response;
    }
}