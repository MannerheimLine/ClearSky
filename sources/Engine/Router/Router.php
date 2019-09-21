<?php


declare(strict_types=1);

namespace Engine\Router;


class Router
{
    private $_routes;

    public function __construct(RouteCollection $routes)
    {
        $this->_routes = $routes;
    }



}