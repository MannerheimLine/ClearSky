<?php


namespace Engine\Database\Connectors;


class PDOEmulator
{
    public function connect(){
        $user = 'root';
        $password = '';
        $dsn = "mysql:host=localhost;dbname=db;charset=utf8";
        $options = array(
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        );
        $db = new \PDO($dsn, $user, $password, $options);
        return $db;
    }

}