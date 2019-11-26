<?php

declare(strict_types = 1);

namespace Engine\RBAC\Domains;


class Permission
{
    private $_name;
    private $_mode;
    private $_message;

    public function __construct(array $permission)
    {
        $this->_name = $permission['name'];
        $this->_mode = $permission['mode'] ?: null;
        $this->_message = $permission['message'] ?: null;

    }

    public function __get($name)
    {
        return $this->$name;
    }

}