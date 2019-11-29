<?php

declare(strict_types = 1);

namespace Engine\Menu\Domains;


use Engine\Database\Connectors\ConnectorInterface;
use Engine\DataStructures\StructuredResponse;

/**
 * Простое меню. Выводит ссылки для указанного меню
 *
 * Class Menu
 * @package Engine\Menu\Domains
 */
class Menu
{
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    /**
     * Выберет ссылки, для нужного меню. Не имеет зависимостей с RBAC. А значит будет показывать все ссылки для
     * выбранного меню. Допуск по ссылкам возлагается на систему RBAC. Позже будет модифицировано.
     *
     * @param int $menuId
     * @return StructuredResponse
     */
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