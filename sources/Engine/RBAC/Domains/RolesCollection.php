<?php

declare(strict_types = 1);

namespace Engine\RBAC\Domains;


use Engine\Database\Connectors\ConnectorInterface;

class RolesCollection
{
    private $_roles = [];
    private $_dbConnector;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnector = $dbConnector;
    }

    /**
     * Инициализация ролей выбранного пользователя
     *
     * @param int $userId
     * @return $this
     */
    public function initRoles(int $userId) : RolesCollection {
        $query = ("SELECT `roles`.`id`, `role_name`, `role_description` FROM `user_roles`
                    INNER JOIN `roles` ON `roles`.`id` = `user_roles`.role_id
                    WHERE `user_roles`.user_id = :userId");
        $result = $this->_dbConnector::getConnection()->prepare($query);
        $result->execute([
            'userId' => $userId
        ]);
        while ($row = $result->fetch()){
            $this->_roles[$row['role_name']] = (new Role($this->_dbConnector))->initPermissions($row['id']);
        }
        return $this;
    }

    /**
     * Проверка по всем ролям в коллекции, привелегий
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission) : bool {
        foreach ($this->_roles as $role){
            /**
             * @var Role $role
             */
            if ($role->hasPermission($permission)){
                return true;
            }
        }
        return false;
    }

}