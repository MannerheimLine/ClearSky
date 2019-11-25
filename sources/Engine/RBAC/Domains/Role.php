<?php

declare(strict_types = 1);

namespace Engine\RBAC\Domains;


use Engine\Database\Connectors\ConnectorInterface;

class Role
{
    private $_permissions;
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    public function create(){

    }

    public function delete(){

    }

    /**
     * Получить все привелегии у текущей роли
     */
    public function initPermissions(){

    }

    public function hasPermission(string $permission) : bool {
        return isset($this->_permissions[$permission]) ? true : false;
    }
}