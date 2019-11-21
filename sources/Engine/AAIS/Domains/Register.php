<?php


namespace Engine\AAIS\Domains;


class Register
{
    public function register(){
        $options = [
            'cost' => 12
        ];
        $hash = password_hash($password, PASSWORD_BCRYPT, $options);
    }

}