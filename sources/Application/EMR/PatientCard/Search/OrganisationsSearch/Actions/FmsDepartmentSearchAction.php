<?php


namespace Application\EMR\PatientCard\Search\OrganisationsSearch\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Search\OrganisationsSearch\Domains\FmsDepartmentSearch;
use Application\EMR\PatientCard\Search\OrganisationsSearch\Responders\FmsDepartmentSearchResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FmsDepartmentSearchAction extends AppAction implements RequestHandlerInterface
{
    private $_fmsDepartmentSearch;

    public function __construct(FmsDepartmentSearch $fmsDepartmentSearch, FmsDepartmentSearchResponder $responder)
    {
        $this->_fmsDepartmentSearch = $fmsDepartmentSearch;
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
        $payload = $this->_fmsDepartmentSearch->searchInsuranceCompany($searchString);
        $response = $this->_responder->respond($request, $payload);

        return $response;
    }
}
