<?php

declare(strict_types = 1);

namespace Engine\Menu\Domains;


use Engine\Database\Connectors\ConnectorInterface;

class Menu
{
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

}