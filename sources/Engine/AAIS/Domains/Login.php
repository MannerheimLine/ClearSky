<?php

declare(strict_types = 1);

namespace Engine\AAIS\Domains;


use Engine\Database\Connectors\ConnectorInterface;
use Engine\DataStructures\StructuredResponse;

/**
 * Class Login
 * @package Engine\AAIS\Domains
 */
class Login
{
    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    /**
     * Слишком сильные пароли со спецсимволами это бред. Достаточно будет паролей в стиле VipNet Password Generator
     *
     * @param string $string
     * @return bool
     */
    private function validateString(string $string) : bool {
        $string = @trim($string);
        if(preg_match("(^[A-Za-z0-9]+$)", $string)){
            return true;
        }
        return false;
    }

    /**
     * @param string $login
     * @return bool|mixed
     */
    private function checkUser(string $login){
        $query = ("SELECT `id`, `password_hash` FROM `user_accounts` WHERE `login` = :login");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'login' => $login
        ]);
        if ($result->rowCount() > 0){
            return $accountData = $result->fetch();
        }
        return false;
    }

    /*
     * После логина записывается uid в сессию и в cookie и в БД
     */
    public function doLogin(string $login, string $password) : StructuredResponse{
        $response = new StructuredResponse();
        /*
         * Валидирую логин пароль, чтобы небыло лишних символов не предусмотренных мной
         */
        if ($this->validateString($login)){
            if ($this->validateString($password)){
                /*
                 * Ищую если пользователь соответствующий логину. Логин уникален.
                 */
                $accountData = $this->checkUser($login);
                if ($accountData !== false){
                    $hash = $accountData['password_hash'];
                    $id = $accountData['id'];
                    /*
                     * Если пользователь найден, то проверяю правильный ли он ввел пароль
                     */
                    if (password_verify($password, $hash)){
                        /*
                         * Дальше мне нужно каждый установить уникальный ключ, который будет потом сверятс яс сессией и
                         * Cookie для того, чтобы знать. Был ли выполнен вход в эту учетную запись на другой машине.
                         * При каждом новом логине ключ обновляется, а значит, на старом устройстве будет log off.
                         * --------------------------------------------------------------------------------------------
                         * Если пароль прошел, то обновляю ключ
                         */
                        $key = sha1(uniqid().$login);
                        $query = ("UPDATE `user_accounts` SET `secret_key` = :secret_key WHERE `id` = :id");
                        $result = $this->_dbConnection->prepare($query);
                        $result->execute([
                            'secret_key' => $key,
                            'id' => $id
                        ]);
                        if ($result){
                            Session::initialize($id, $key);
                            Cookie::create($id, $key);
                        }
                    }else{
                        //Неверный пароль
                    }
                }else{
                    //Пользователь не найден
                }
            }else{
                //Недопустимый синтаксис в пароле
            }
        }else{
            //Недопустимый синтаксис в логине
        }
        return $response;
    }


}