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
        //$_SESSION['user']['profile']['login'] = $login;
    }
}