<?php

declare(strict_types = 1);

namespace Engine\AAIS\Domains;

/**
 * Class Session
 * @package Engine\AAIS\Domains
 */
class Session
{
    public static function initialize(int $id, string $key) : void {
        $_SESSION['user']['account']['id'] = $id;
        $_SESSION['user']['account']['key'] = $key;
    }

    public static function getId(){
       return $_SESSION['user']['account']['id'];
    }

    public static function getKey(){
        return $_SESSION['user']['account']['key'];
    }
}