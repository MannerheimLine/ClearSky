<?php


declare(strict_types = 1);

namespace Engine\Router;


use Engine\Router\DataStructures\Route;

class RouteCollection
{
    private $_routes = [];

    public function get(string $name, string $pattern, string $controller, string $action, array $attributes) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, $attributes, ['GET']);
    }

    public function post(string $name, string $pattern, string $controller, string $action, array $attributes) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, $attributes, ['POST']);
    }

    public function put(string $name, string $pattern, string $controller, string $action,  array $attributes) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, $attributes, ['PUT']);
    }

    public function patch(string $name, string $pattern, string $controller, string $action, array $attributes) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, $attributes, ['PATCH']);
    }

    public function delete(string $name, string $pattern, string $controller, string $action, array $attributes) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, $attributes, ['DELETE']);
    }

    public function head(string $name, string $pattern, string $controller, string $action, array $attributes) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, $attributes, ['HEAD']);
    }

    /**
     * Вернуть массив объектов Route. Маршруты
     * ---------------------------------------
     * @return Route
     */
    public function getRoutes() : array {
        return $this->_routes;
    }
}