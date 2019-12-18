<?php

declare(strict_types = 1);

namespace Engine\RBAC\Domains;

/**
 * Данный класс является коллекцией привелегий, которые существуют в системе.
 * В общем смысле доступ к любому разделу, действие совершаемое это все регламентируется привилегиями.
 *
 * Class PermissionsCollection
 * @package Engine\RBAC\Domains
 */
class PermissionsCollection
{
    const PERMIT_MODE = 0;
    const REDIRECT_MODE = 1;
    const FORBIDDEN_MODE = 2;

    private static $_permissions = [
        'default' => [
            'name' => 'permittedAccess',
            'mode' => self::PERMIT_MODE,
            'message' => 'Разрешено'
        ],

        'patient-card' => [
            'name' => 'patientCardAccess',
            'mode' => self::FORBIDDEN_MODE,
            'message' => 'Доступ в разде карт Вам закрыт'
        ],

        'patient-card/edit' => [
            'name' => 'patientCardEdit',
            'mode' => self::FORBIDDEN_MODE,
            'message' => 'Редактирование карты Вам запрещено'
        ],

        'patient-card/delete' => [
            'name' => 'patientCardDelete',
            'mode' => self::FORBIDDEN_MODE,
            'message' => 'Удалять карты Вам запрещено'
        ]
    ];

    /**
     * @param $url
     * @return Permission
     */
    public static function get($url) : Permission{
        $permission = self::$_permissions[$url] ?: self::$_permissions['default'];
        return new Permission($permission);
    }

}