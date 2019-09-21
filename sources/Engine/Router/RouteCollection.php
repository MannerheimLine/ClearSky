<?php


declare(strict_types=1);

namespace Engine\Router;


class RouteCollection
{
    private $_routes = [];

    public function get(string $name, string $pattern, string $controller, string $action, array $params = []) : void {
        $this->_routes = new Route($name, $pattern, $controller, $action, ['GET'], $params);
    }

    public function post(string $name, string $pattern, string $controller, string $action, array $params = []) : void {
        $this->_routes = new Route($name, $pattern, $controller, $action, ['POST'], $params);
    }

    public function getRoutes() : array {
        return $this->_routes;
    }
}