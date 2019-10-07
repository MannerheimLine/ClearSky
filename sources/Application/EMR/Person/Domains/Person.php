<?php


namespace Application\EMR\Person\Domains;


use Application\Base\AppDomain;
use Engine\Database\Connectors\ConnectorInterface;
use Engine\Database\Connectors\MySQLConnector;

class Person extends AppDomain
{
    private $_dbConnection;

    /**
     * Person constructor.
     * @param ConnectorInterface $dbConnector
     */
    public function __construct(ConnectorInterface $dbConnector)
    {
        //$this->_dbConnection = $dbConnector->getConnection();

    }

    public function getPersonalData(){
        return ['id' => 1, 'name' => 'Petr', 'surname' => 'Ivanov'];
    }

}