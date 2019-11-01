<?php


namespace Application\EMR\PatientCard\Search\OrganisationsSearch\Actions;


use Application\Base\AppAction;
use Application\EMR\PatientCard\Search\OrganisationsSearch\Domains\InsuranceCompanySearch;
use Application\EMR\PatientCard\Search\OrganisationsSearch\Responders\InsuranceCompanySearchResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class InsuranceCompanySearchAction extends AppAction implements RequestHandlerInterface
{
    private $_searchInsuranceCompany;

    public function __construct(InsuranceCompanySearch $searchInsuranceCompany, InsuranceCompanySearchResponder $responder)
    {
        $this->_searchInsuranceCompany = $searchInsuranceCompany;
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
        $payload = $this->_searchInsuranceCompany->searchInsuranceCompany($searchString);
        $response = $this->_responder->respond($request, $payload);

        return $response;
    }
}
