<?php

declare(strict_types = 1);

namespace Engine\Database\Connectors;


class MySQLConnector implements ConnectorInterface
{
    private static $_instance = null;
    //private function __construct() {}
    //private function __clone() {}


    /**
     * @return PDOEmulator|\PDO|null
     */
    public static function getConnection() {
        if (is_null(self::$_instance)) {
            try {
                $params = include 'config/db_configs.php';
                $host = $params['host'];
                $db = $params['dbname'];
                $charset = $params['charset'];
                $user = $params['user'];
                $password = $params['password'];
                //Переменные опций PDO
                $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
                $options = array(
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES   => false,
                );
                self::$_instance = new \PDO($dsn, $user, $password, $options);
            } catch (\PDOException $e) {
                throw new \Exception('Ошибка соединения с базой данных '.$e->getMessage());
            }
        }
        return self::$_instance;
    }

}