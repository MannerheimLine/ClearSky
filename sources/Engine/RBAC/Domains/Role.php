<?php

declare(strict_types = 1);

namespace Engine\RBAC\Domains;


use Engine\Database\Connectors\ConnectorInterface;

class Role
{
    private $_permissions = [];
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector::getConnection();
    }

    public function create(){

    }

    public function delete(){

    }

    /**
     * Получить все привелегии у текущей роли
     */
    public function initPermissions(int $roleId) : Role {
        $query = ("SELECT `permission_name`, `permission_description` FROM `role_permission`
                    INNER JOIN `permissions` ON permissions.id = role_permission.permission_id
                    WHERE `role_permission`.role_id = :roleId");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'roleId' => $roleId
        ]);
        while ($row = $result->fetch()){
            $this->_permissions[$row['permission_name']] = $row['permission_description'];
        }
        return $this;
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission) : bool {
        return isset($this->_permissions[$permission]);
    }
}