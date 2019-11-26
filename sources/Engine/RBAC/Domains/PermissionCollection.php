<?php

declare(strict_types = 1);

namespace Engine\RBAC\Domains;


class PermissionCollection
{
    const REDIRECT_MODE = 1;
    const RESPONSE_MODE = 2;

    private $_permissions = [
        'patient-card' => [
            'name' => 'patientCardAccess',
            'mode' => self::REDIRECT_MODE],
        'patient-card/update' => [
            'name' => 'patientCardUpdate',
            'mode' => self::RESPONSE_MODE,
            'message' => 'Редактирование карты вам запрещено']
    ];

    public function get($url){
        $permission = $this->_permissions[$url] ?: ['name' => 'permitted'];
        return new Permission($permission);
    }

}