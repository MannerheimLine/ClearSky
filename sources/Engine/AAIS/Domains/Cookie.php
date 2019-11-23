<?php

declare(strict_types = 1);

namespace Engine\AAIS\Domains;

use Engine\Base\App;
use Engine\Database\Connectors\ConnectorInterface;

/**
 * Задачи класса:
 * - Создать Cookie для последующей автоматической авторизации
 * - Проверить Cookie на пригодность. Годится она для авторизации или нет.
 *
 * Class Cookie
 * @package Engine\AAIS\Domains
 */
class Cookie
{
    /**
     * Создаю куки, для авторизации пользователя
     *
     * @param int $id
     * @param string $key
     */
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

    /**
     * Проверка куки, если такое есть в браузере.
     *
     * @return bool
     */
    public static function isValid() : bool {
        if (isset($_COOKIE['AuthUserRestrictedArea'])){
            $explodedCookie = explode("-", $_COOKIE['AuthUserRestrictedArea']);
            $id = (int)$explodedCookie[0];
            $cookieHash = $explodedCookie[1];
            $query = ("SELECT `secret_key` FROM `user_accounts` WHERE `id` = :id");
            /**
             * @var ConnectorInterface $connector
             */
            $connector = App::getDependency(ConnectorInterface::class);
            $result = $connector::getConnection()->prepare($query);
            /**
             * @var \PDOStatement $result
             */
            $result->execute([
                'id' => $id
            ]);
            if ($result->rowCount() > 0){
                $key = $result->fetch()['secret_key'];
                $evaluateHash = sha1($key.":".$_SERVER['HTTP_USER_AGENT'].":".$_SERVER["REMOTE_ADDR"]);
                if ($cookieHash === $evaluateHash){
                    Session::initialize($id, $key);
                    return true;
                }
            }
        }
        return false;
    }
}