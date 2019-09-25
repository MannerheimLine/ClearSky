<?php


declare(strict_types = 1);

namespace Engine\Router;


class RouteCollection
{
    private $_routes = [];

    public function get(string $name, string $pattern, string $controller, string $action) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, ['GET']);
    }

    public function post(string $name, string $pattern, string $controller, string $action) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, ['POST']);
    }

    public function put(string $name, string $pattern, string $controller, string $action) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, ['PUT']);
    }

    public function patch(string $name, string $pattern, string $controller, string $action) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, ['PATCH']);
    }

    public function delete(string $name, string $pattern, string $controller, string $action) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, ['DELETE']);
    }

    public function head(string $name, string $pattern, string $controller, string $action) : void {
        $this->_routes[] = new Route($name, $pattern, $controller, $action, ['HEAD']);
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