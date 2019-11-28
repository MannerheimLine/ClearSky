<?php

declare(strict_types = 1);

namespace Engine\Menu\Domains;


use Engine\Database\Connectors\ConnectorInterface;
use Engine\DataStructures\StructuredResponse;

class Menu
{
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    public function getMenuLinks(int $menuId) : StructuredResponse {
        $query = ("SELECT * FROM `menu_links` WHERE `menu` = :menuId");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'menuId' => $menuId
        ]);
        $structuredResponse = new StructuredResponse();
        if ($result->rowCount() > 0){
            $message = $structuredResponse->message($structuredResponse::SUCCESS, 'Меню загружено');
            $structuredResponse->success()->complete('response', ['message' => $message, 'menu' =>$result->fetchAll()]);
        }else{
            $message = $structuredResponse->message($structuredResponse::FAIL, 'Меню не удается загрузить');
            $structuredResponse->failed()->incomplete('message', $message);
        }
        return $structuredResponse;
    }

}