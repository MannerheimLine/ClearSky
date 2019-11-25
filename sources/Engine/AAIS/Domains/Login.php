<?php

declare(strict_types = 1);

namespace Engine\AAIS\Domains;


use Engine\Database\Connectors\ConnectorInterface;
use Engine\DataStructures\StructuredResponse;

/**
 * Задачи класса:
 * - Идентификация по введеному имени учетной записи
 * - Аутентификация по введеному паролю учетной записи
 *
 * Class Login
 * @package Engine\AAIS\Domains
 */
class Login
{
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    /**
     * Проверяет наличие учетной записи пользователя, для дальнейшей авторизации
     *
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

    /**
     * Идентификация и аутентификация по введенным параметрам учетной записи
     */
    public function doLogin(string $login, string $password) : StructuredResponse{
        $response = new StructuredResponse();
        /**
                 * Ищую если пользователь соответствующий логину. Логин уникален.
                 */
        $accountData = $this->checkUser($login);
        if ($accountData !== false){
            $hash = $accountData['password_hash'];
            $id = $accountData['id'];
            /**
             * Если пользователь найден, то проверяю правильный ли он ввел пароль
             */
            if (password_verify($password, $hash)){
                /**
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
                    $response->success();
                    $message = $response->message($response::SUCCESS, 'Вы авторизованны');
                    $response->complete('response', ['message' => $message]);
                }
            }else{
                $response->failed();
                $message = $response->message($response::FAIL, 'Введенный вами пароль не совпадает с учетной записью');
                $response->incomplete('response', ['message' => $message]);
            }
        }else{
            $response->failed();
            $message = $response->message($response::FAIL, 'Пользователь с такой учетной записью не найден. Я гарантирую это.');
            $response->incomplete('response', ['message' => $message]);
        }
        return $response;
    }

    /**
     * Выход из системы
     *
     * @return StructuredResponse
     */
    public function doLogout() : StructuredResponse {
        $response = new StructuredResponse();
        if (setcookie('AuthUserRestrictedArea',"",time() - 86400,'/')){
            if (session_unset()){
                if (session_destroy()){
                    $message = $response->message($response::SUCCESS, 'Вы вышли из системы!');
                    $response->success()->complete('message', $message);
                }else{
                    $message = $response->message($response::FAIL, 'Не удалось удалить сессию');
                    $response->failed()->incomplete('message', $message);
                }
            }else{
                $message = $response->message($response::FAIL, 'Не удалось очистить переменные сессии');
                $response->failed()->incomplete('message', $message);
            }
        }else{
            $message = $response->message($response::FAIL, 'Не удалось очистить куки');
            $response->failed()->incomplete('message', $message);
        }
        return $response;
    }
}