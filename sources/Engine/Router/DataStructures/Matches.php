<?php

declare(strict_types = 1);

namespace Engine\Router\DataStructures;

/**
 * Class Matches
 * -------------------------------------------------------
 * Структура данных с информацией о распарсенном маршруте.
 * -------------------------------------------------------
 * @package Engine\Router
 */

class Matches
{
    private $_name;
    private $_controller;
    private $_action;
    private $_attributes;

    /**
     * Matches constructor.
     * @param string $name
     * @param string $controller
     * @param string $action
     * @param array $attributes
     */
    public function __construct(string $name, string $controller, string $action, array $attributes)
    {
        $this->_name = $name;
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->_controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->_action;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->_attributes;
    }

}