<?php

declare(strict_types = 1);

namespace Engine\DataStructures;

/**
 * Status: success / fail - поможет определять секцию для обращения за данными
 * Message: специальный раздел для сообщений для пользователя
 * Content: к данному блоку нужно обращатся если статус Success
 * Errors: к данному блоку нужно обращатся если статус Fail
 * Подобная структура дает возможность отправлять структуированный, стандартизированный ответ(Response) браузеру, где
 * его можно удобно разобрать в JS
 * - Status
 * - Message
 * - Content
 * - Errors
 * Внутренние иерархии внутри секции идут на выбор и могу ветвится как угодно
 *
 * Class StructuredResponse
 * @package Engine\DataStructures
 */
class StructuredResponse implements \JsonSerializable
{
    protected $_status;
    protected $_complete = [];
    protected $_errors = [];

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'status' => $this->_status,
            'complete' => $this->_complete,
            'incomplete' => $this->_errors
        ];
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function failed() : StructuredResponse {
        $this->_status = 'fail';
        return $this;
    }

    public function success() : StructuredResponse {
        $this->_status = 'success';
        return $this;
    }

    public function message(string $status, string $text) : array {
        return ['status' => $status, 'text' => $text];
    }

    public function complete(string $field, $data) : void {
        $this->_complete[$field][] = $data;
    }

    public function incomplete(string $field, $data) : void {
        $this->_errors[$field][] = $data;
    }

}






