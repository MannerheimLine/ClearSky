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

    private function getUsers(){
        $query = ("SELECT `user_accounts`.`id`, `login`, `surname`, `firstname`, `secondname`
                   FROM `user_accounts`
                   LEFT JOIN `user_profiles` ON `user_profiles`.`account` = `user_accounts`.`id`");
        $result = $this->_dbConnection->prepare($query);
        $result->execute();
        if ($result->rowCount() > 0){
            return $result->fetchAll();
        }
        return null;
    }

    private function initUserWithRoles(array $user) : array {
        /**
         * При создании пользователя, по умолчанию сделать добавление ему роли "Пользователь"
         */
        /*$query = ("SELECT `user_profiles`.`surname`, `user_accounts`.`login`,`user_accounts`.`id`, `role_name`, `role_description` FROM `user_roles`
                    INNER JOIN `roles` ON `roles`.`id` = `user_roles`.role_id
                    INNER JOIN `user_accounts` ON `user_accounts`.`id` = `user_roles`.`user_id`
                    LEFT JOIN `user_profiles` ON `user_profiles`.`account` = `user_accounts`.`id` LIMIT 10");*/
        $query = ("SELECT `roles`.`id`, `role_name`, `role_description` FROM `user_roles`
                    INNER JOIN `roles` ON `roles`.`id` = `user_roles`.role_id
                    INNER JOIN `user_accounts` ON `user_accounts`.`id` = `user_roles`.`user_id`
                    WHERE `user_roles`.`user_id` = :user_id");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'user_id' => $user['id']
        ]);
        $user['roles'] = $result->fetchAll();
        return $user;
    }

    public function getAll() : array {
        $users = $this->getUsers();
        if (isset($users)){
            foreach ($users as $user){
                $initiatedUsers[] = $this->initUserWithRoles($user);
            }
        }

        return $initiatedUsers;
    }

}