<?php

declare(strict_types = 1);

namespace Engine\RBAC\Domains;


use Engine\AAIS\Domains\Session;
use phpDocumentor\Reflection\Types\This;

class PrivilegedUser
{
    private $_roles;

    public function init(int $id){
        Session::getId();
        //Далее SQL запрос и инициадлизациия пользователя

        return $this;

    }

    public function initRoles(){

    }

    public function hasPermission(string $permission) : bool {
        foreach ($this->_roles as $role){
            /**
             * @var Role $role
             */
            if ($role->hasPermission($permission)){
                return true;
            }
        }
        return false;
    }

}