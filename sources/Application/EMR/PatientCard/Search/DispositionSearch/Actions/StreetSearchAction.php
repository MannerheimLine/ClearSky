<?php


namespace Application\EMR\PatientCard\Search\DispositionSearch\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Search\DispositionSearch\Domains\DispositionSearch;
use Application\EMR\PatientCard\Search\DispositionSearch\Responders\StreetSearchResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StreetSearchAction extends AppAction implements RequestHandlerInterface
{
    private $_dispositionSearch;

    public function __construct(DispositionSearch $searchDisposition, StreetSearchResponder $responder)
    {
        $this->_dispositionSearch = $searchDisposition;
        $this->_responder = $responder;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $searchData = $request->getAttribute('getParams');
        $payload = $this->_dispositionSearch->searchStreet($searchData);
        $response = $this->_responder->respond($request, $payload);

        return $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080');
    }
}
