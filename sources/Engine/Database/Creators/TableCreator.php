<?php

declare(strict_types = 1);

namespace Engine\Database\Creators;


use Engine\Database\Connectors\ConnectorInterface;

class TableCreator
{
    private $_fields = []; //Содержит в себе объекты полей таблицы
    private $_tableInfo = [];
    private $_connection;

    public function __construct(ConnectorInterface $connector, SchemeExplorer $schemeExplorer)
    {
        $this->_connection = $connector::getConnection();
        $this->_tableInfo = $schemeExplorer->getTableInfo();
        $this->_fields = $schemeExplorer->getFields();
        ;
    }

    private function convertFields() : string {
        //инициализация полей уже в форме SQL запроса
        foreach ($this->_fields as $field) {
            $string ='';
        }
        return $string;
    }

    private function createQuery(string $fields){
        //Инициализация имени, типа таблицы, комментариев и тд уже в форме SQL запроса

        /*
         * $query = ("CREATE TABLE `users` (
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
         *
         */

        $name = $this->_tableInfo['name']; //обернуть
        $charset = $this->_tableInfo['charset']; //обернуть
        $engine = $this->_tableInfo['engine']; //обернуть
        $comment = $this->_tableInfo['comment']; //обернуть
        $string =("CREATE TABLE $name ($fields) ENGINE=$engine DEFAULT CHARSET=$charset COMMENT=$comment;");
        return $string;
    }

    public function create(){
        $fields = $this->convertFields();
        $query = $this->createQuery($fields);
        $result = $this->_connection->connect()->prepare($query);
        $result->execute();
    }

}
