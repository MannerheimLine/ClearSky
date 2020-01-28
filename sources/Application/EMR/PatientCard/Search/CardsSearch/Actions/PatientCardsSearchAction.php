<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Search\CardsSearch\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Search\CardsSearch\Domains\PatientCards;
use Application\EMR\PatientCard\Search\CardsSearch\Responders\PatientCardsSearchResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PatientCardsSearchAction extends AppAction implements RequestHandlerInterface
{
    private $_patientCards;

    public function __construct(PatientCards $patientCards, PatientCardsSearchResponder $responder)
    {
        $this->_patientCards = $patientCards;
        $this->_responder = $responder;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = json_decode(file_get_contents("php://input"),true);
        $searchString = $data['searchString'];
        $page = $data['selectedPage'];
        //$searchString = $request->getParsedBody()['searchString'];
        //$page = $request->getParsedBody()['selectedPage'];
        $payload = $this->_patientCards->getCardsData($searchString, (int)$page);
        $response = $this->_responder->respond($request, $payload);

        //return $response;
        return $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080');
    }
}
