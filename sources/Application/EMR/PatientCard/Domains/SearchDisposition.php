<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Domains;


use Application\Base\AppDomain;
use Engine\Database\Connectors\ConnectorInterface;

/**
 * Один общий класс для поиска данных в полях относящихся к адресу
 *
 * Class SearchDisposition
 * @package Application\EMR\PatientCard\Domains
 */
class SearchDisposition extends AppDomain
{
    private $_limit = 5;
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    public function searchRegion(string $searchString){
        $searchString = $this->sanitize($searchString);
        $query = ("SELECT * FROM `regions` WHERE `region_name` LIKE '%$searchString%' LIMIT $this->_limit;");
        $result = $this->_dbConnection->prepare($query);
        $result->execute();
        if ($result->rowCount() > 0){
            return $result->fetchAll();
        }
        return 'Ничего не найдено';
    }

    public function searchDistrict(string $searchString){

    }

    public function searchStreet(string $searchString){

    }

}