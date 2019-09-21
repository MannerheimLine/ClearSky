<?php


declare(strict_types=1);

namespace Engine\Router;


class Route
{
    private $_name;
    private $_pattern;
    private $_controller;
    private $_action;
    private $_methods;
    private $_params;

    public function __construct(string $name, string $pattern, string $controller, string $action, array $methods, array $params = [])
    {
        $this->_name = $name;
        $this->_pattern = $pattern;
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_methods = $methods;
        $this->_params = $params;

    }

}