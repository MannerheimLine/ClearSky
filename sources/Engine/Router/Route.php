<?php


declare(strict_types = 1);

namespace Engine\Router;


class Route
{
    private $_name;
    private $_pattern;
    private $_controller;
    private $_action;
    private $_methods;

    public function __construct(string $name, string $pattern, string $controller, string $action, array $methods)
    {
        $this->_name = $name;
        $this->_pattern = $pattern;
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_methods = $methods;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->_pattern;
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
    public function getMethods(): array
    {
        return $this->_methods;
    }

}