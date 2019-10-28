<?php


namespace Application\EMR\PatientCard\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Domains\SearchDisposition;
use Application\EMR\PatientCard\Responders\SearchRegionDepositionResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SearchRegionDepositionAction extends AppAction implements RequestHandlerInterface
{
    private $_searchDisposition;

    public function __construct(SearchDisposition $patientCards, SearchRegionDepositionResponder $responder)
    {
        $this->_searchDisposition = $patientCards;
        $this->_responder = $responder;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $searchString = $request->getParsedBody()['searchString'];
        $payload = $this->_searchDisposition->searchRegion($searchString);
        $response = $this->_responder->respond($request, $payload);

        return $response;
    }
}