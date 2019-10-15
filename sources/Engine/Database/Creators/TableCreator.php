<?php

declare(strict_types = 1);

namespace Engine\Database\Creators;


use Engine\Database\Connectors\ConnectorInterface;
use Engine\Database\Creators\DataStructures\Scheme;

/**
 * Class TableCreator
 * @package Engine\Database\Creators
 */
class TableCreator
{
    private $_connection;

    /**
     * 1 Схема = 1 Таблица. Так можно будет запускать создание через цикл
     * $schemes = $schemeCollection->getSchemes();
     * $foreach ($schemes as $scheme){$creator->create}
     * ------------------------------------------------------------------
     * TableCreator constructor.
     * @param ConnectorInterface $connector
     * @param Scheme $scheme
     */
    public function __construct(ConnectorInterface $connector)
    {
        $this->_connection = $connector::getConnection();
    }

    private function convertToSQLString(array $field) : string {
        //инициализация полей уже в форме SQL запроса

    }

    private function createQuery(Scheme $scheme){
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

        $fields = $scheme->getFields();
        $info = $scheme->getInfo();
        $sqlString = '(';
        foreach ($fields as $field){
            $sqlString = $sqlString.$this->convertToSQLString($field).',';
        }
        $sqlString = $sqlString.')';
        $string =("CREATE TABLE :tableName ($fields) ENGINE=$engine DEFAULT CHARSET=$charset COMMENT=$comment;");
        return $string;
    }

    public function create(Scheme $scheme){
        $arr = [
            'name' => 'id',
            'type' => 'int',
            'size' => 10,
            'defaultValue' => '1',
            'charset' => 'utf8',
            'attributes' => 'UNSIGNED',
            'allowNull' => false,
            'index' => 'PRIMARY',
            'allowAI' => true,
            'comment' => 'id - пользователя'];
        //`id` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'comment'
        $name = '`'.$arr['name'].'`';
        $type = $arr['type'].'('.$arr['size'].')';
        $attributes = $arr['attributes'];
        $allowNull = $arr['allowNull'] ? '':'NOT NULL';
        $default = 'DEFAULT'.' '."'".$arr['defaultValue']."'";
        $comment = 'COMMENT'.' '."'".$arr['comment']."'";
        $string = $name.' '.$type.' '.$attributes.' '.$allowNull.' '.$default.' '.$comment;
        $a = 1;
        //$query = $this->createQuery($scheme);
        //$result = $this->_connection->connect()->prepare($query);
        //$result->execute();
    }

}
