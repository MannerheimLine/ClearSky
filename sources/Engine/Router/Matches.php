<?php

declare(strict_types = 1);

namespace Engine\Router;

class Matches
{
    private $_name;
    private $_controller;
    private $_action;
    private $_params;

    public function __construct(string $name, string $controller, string $action, array $params)
    {
        $this->_name = $name;
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_params = $params;
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
    public function getParams(): array
    {
        return $this->_params;
    }

}