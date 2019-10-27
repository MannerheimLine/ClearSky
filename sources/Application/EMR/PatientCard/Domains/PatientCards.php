<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Domains;


use Application\Base\AppDomain;
use Engine\Database\Connectors\ConnectorInterface;

class PatientCards extends AppDomain
{
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    public function getCardsData(string $searchString){
        $searchString = $this->sanitize($searchString);
        $query = ("SELECT `id`, `card_number`, `is_alive`, `is_attached`, `surname`, `firstname`, `secondname`, `policy_number`, `insurance`
        FROM `patient_cards`
        WHERE `policy_number` LIKE '%$searchString%' OR CONCAT(`surname`, ' ', `firstname`, ' ', `secondname`) LIKE '%$searchString%'");
        $result = $this->_dbConnection->prepare($query);
        $result->execute();
        if ($result->rowCount() > 0){
            $cards = $result->fetchAll();
            return $cards;
        }
    }

}