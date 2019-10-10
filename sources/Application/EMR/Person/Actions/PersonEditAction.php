<?php


namespace Application\EMR\Person\Actions;


use Application\Base\AppAction;
use Application\EMR\Person\Domains\Person;
use Application\EMR\Person\Responders\PersonEditResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PersonEditAction extends AppAction implements RequestHandlerInterface
{
    public function __construct(Person $person, PersonEditResponder $responder)
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
