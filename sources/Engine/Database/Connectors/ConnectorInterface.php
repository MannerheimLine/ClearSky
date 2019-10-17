<?php


namespace Engine\Database\Connectors;


interface ConnectorInterface
{
    /**
     * Вернет подключение к базе данных
     * --------------------------------
     * @return \PDO
     */
    public static function getConnection();
}