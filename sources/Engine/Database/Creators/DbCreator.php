<?php

declare(strict_types = 1);

namespace Engine\Database\Creators;


use Engine\Database\Connectors\ConnectorInterface;
use PDO;
use PDOException;

class DbCreator
{
    const DB_EXIST = 'Такая Бд уже существует';
    const DB_CREATED = 'База данных успешно создана';

    public function __construct(ConnectorInterface $connection)
    {
        $this->_connection = $connection;
    }

    private function isExist(PDO $pdo, string $dbName) : bool {
        try{
            $pdo->query("use $dbName");
            return true;
        }catch (PDOException $e){
            return false;
        }
    }

    public function createDataBase(string $dbName) : string {
        $pdo = new PDO("mysql:host=localhost", 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (!$this->isExist($pdo, $dbName)){
            $dbName = "`".str_replace("`","``", $dbName)."`";
            $pdo->query("CREATE DATABASE IF NOT EXISTS $dbName DEFAULT CHARACTER SET utf8;");
            $pdo->query("use $dbName");
            return self::DB_CREATED;
        }
        return self::DB_EXIST;
    }

    /*public function createTable(string $tableName){
        $db = $this->_connection::getConnection()->connect();
        $query = ("CREATE TABLE `users` (
                    `id` int(10) UNSIGNED NOT NULL COMMENT 'id - пользователя',
                    `login` varchar(20) NOT NULL COMMENT 'логин',
                    `password` varchar(255) NOT NULL COMMENT 'пароль',
                      `secret_key` varchar(255) NOT NULL COMMENT 'секретный ключ',
                      `position` tinyint(1) UNSIGNED NOT NULL COMMENT 'должность',
                      `foto` varchar(255) DEFAULT NULL COMMENT 'ссылка на фотографию',
                      `party` tinyint(1) UNSIGNED NOT NULL DEFAULT '5' COMMENT 'группа в которой состоит пользователь',
                      `surname` varchar(255) NOT NULL DEFAULT 'Doe' COMMENT 'фамилия',
                      `firstname` varchar(255) NOT NULL DEFAULT 'John/Jane' COMMENT 'имя',
                      `secondname` varchar(255) DEFAULT NULL COMMENT 'отчество',
                      `gender` tinyint(1) UNSIGNED NOT NULL COMMENT 'пол'
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с данными о пользователях системы';");
        $result = $db->prepare($query);
        $result->execute();

    }*/

}
