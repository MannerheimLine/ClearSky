<?php


namespace Administrator\Users\Domains;


use Engine\Database\Connectors\ConnectorInterface;

class Users
{
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector::getConnection();
    }

    public function getAll(){
        $query = ("SELECT `login`, `surname`, `firstname`, `secondname`
                   FROM `user_accounts`
                   LEFT JOIN `user_profiles` ON `user_profiles`.`account` = `user_accounts`.`id`");
        $result = $this->_dbConnection->prepare($query);
        $result->execute();
        if ($result->rowCount() > 0){
            return $result->fetchAll();
        }
        return null;
    }

}