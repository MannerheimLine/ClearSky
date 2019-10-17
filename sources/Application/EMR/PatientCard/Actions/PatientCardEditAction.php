<?php


namespace Application\EMR\PatientCard\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Domains\PatientCard;
use Application\EMR\PatientCard\Responders\PersonEditResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PatientCardEditAction extends AppAction implements RequestHandlerInterface
{
    public function __construct(PatientCard $person, PersonEditResponder $responder)
    {
        $this->_person = $person;
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
        $payload = $this->_person->edit($id);
        $response = $this->_responder->respond($request, $payload);
        return $response;
    }
}
