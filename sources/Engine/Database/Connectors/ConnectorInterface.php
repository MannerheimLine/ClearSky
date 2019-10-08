<?php


namespace Engine\Database\Connectors;


interface ConnectorInterface
{
    /**
     * Вернет подключение к базе данных
     * --------------------------------
     * @return \Engine\Database\Connectors\PDOEmulator
     */
    public static function getConnection();
}