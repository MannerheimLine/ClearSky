<?php

declare(strict_types = 1);

namespace Engine\AAIS\Domains;

use Engine\Database\Connectors\ConnectorInterface;

/**
 * Class Cookie
 * @package Engine\AAIS\Domains
 */
class Cookie
{
    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    public static function create(int $id, string $key) : void {
        /**
         * Тут я должен захэшировать значение куки. В чистом виде секретный ключ хранить не лучшая идея потому что
         * достаточно просто опдставить себе куку с секретным ключем и можно спокойно работат ьпод пользователем.
         * В моем случае из куки не ясно какой в базе хранится секретный ключ, плюс нужн осовпадение по ip и user agent'у
         */
        setcookie(
            'AuthUserRestrictedArea',
            $id.'-'.sha1($key.":".$_SERVER['HTTP_USER_AGENT'].":".$_SERVER["REMOTE_ADDR"]),
            time() + 86400,
            '/'
        );
    }

    public function inspectCookie(){
        $explodedCookie = explode("-", $_COOKIE['AuthUserRestrictedArea']);
        $id = $explodedCookie[0];
        $cookieHash = $explodedCookie[1];
        $query = ("SELECT `secret_key` FROM `user_accounts` WHERE `id` = :id");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'id' => $id
        ]);
        if ($result->rowCount() > 0){
            $key = $result->fetch()['secret_key'];
        }
        $evaluateHash = sha1($key.":".$_SERVER['HTTP_USER_AGENT'].":".$_SERVER["REMOTE_ADDR"]);
        if ($cookieHash === $evaluateHash){
            return true;
        }
        return false;
    }
}