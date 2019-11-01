<?php


namespace Application\EMR\PatientCard\Search\OrganisationsSearch\Domains;


use Application\Base\AppDomain;
use Engine\Database\Connectors\ConnectorInterface;

class InsuranceCompanySearch  extends AppDomain
{
    private $_limit = 5;
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    public function searchInsuranceCompany(string $searchString){
        $searchString = $this->sanitize($searchString);
        $query = ("SELECT * FROM `insurance_companies` WHERE `insurance_company_name` LIKE '%$searchString%' LIMIT $this->_limit;");
        $result = $this->_dbConnection->prepare($query);
        $result->execute();
        if ($result->rowCount() > 0){
            $i = 0;
            while ($row = $result->fetch()){
                $data[$i]['id'] = $row['id'];
                $data[$i]['value'] = $row['insurance_company_name'];
                $i ++;
            }
            return $data;
        }
        return 'Nothing found';
    }
}
