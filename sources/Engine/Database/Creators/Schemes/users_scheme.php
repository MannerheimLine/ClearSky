<?php
return [
    'info' => [
        'name' => 'users',
        'charset' => 'utf8',
        'engine' => 'InnoDB',
        'comment' => 'Таблица с данными о пользователях системы',
        'version' => 1.0
    ],
    'fields' => [
        'id' => [
            'name' => 'id',
            'type' => 'int',
            'size' => 10,
            'defaultValue' => '',
            'charset' => 'utf8',
            'attributes' => 'UNSIGNED',
            'allowNull' => false,
            'index' => 'PRIMARY',
            'allowAI' => true,
            'comment' => 'id - пользователя'
        ],
        'user_name' => [
            'name' => 'user_name',
            'type' => 'varchar',
            'size' => 20,
            'defaultValue' => '',
            'charset' => 'utf8',
            'attributes' => '',
            'allowNull' => false,
            'index' => '',
            'allowAI' => false,
            'comment' => 'логин'
        ],
    ]
];
