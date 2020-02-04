<?php


namespace Application\EMR\PatientCard\Search\DispositionSearch\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Search\DispositionSearch\Domains\DispositionSearch;
use Application\EMR\PatientCard\Search\DispositionSearch\Responders\LocalitySearchResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LocalitySearchAction extends AppAction implements RequestHandlerInterface
{
    private $_dispositionSearch;

    public function __construct(DispositionSearch $searchDisposition, LocalitySearchResponder $responder)
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
        $payload = $this->_dispositionSearch->searchLocality($searchData);
        $response = $this->_responder->respond($request, $payload);

        return $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080');
    }
}
