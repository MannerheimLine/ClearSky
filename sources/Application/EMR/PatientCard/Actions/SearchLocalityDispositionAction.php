<?php


namespace Application\EMR\PatientCard\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Domains\SearchDisposition;
use Application\EMR\PatientCard\Responders\SearchRegionDispositionResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SearchLocalityDispositionAction extends AppAction implements RequestHandlerInterface
{
    private $_searchDisposition;

    public function __construct(SearchDisposition $searchDisposition, SearchRegionDispositionResponder $responder)
    {
        $this->_searchDisposition = $searchDisposition;
        $this->_responder = $responder;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $searchData = $request->getParsedBody();
        $payload = $this->_searchDisposition->searchLocality($searchData);
        $response = $this->_responder->respond($request, $payload);

        return $response;
    }
}
