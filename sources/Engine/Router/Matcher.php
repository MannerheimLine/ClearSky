<?php

declare(strict_types = 1);

namespace Engine\Router;

use Psr\Http\Message\ServerRequestInterface;

class Matcher
{
    private $_routes;

    /**
     * Matcher constructor.
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes)
    {
        $this->_routes = $routes;
    }

    /**
     * @param ServerRequestInterface $request
     * @return Matches
     */
    public function match(ServerRequestInterface $request) : Matches {
        foreach ($this->_routes->getRoutes() as $route){
            if ($route->getMethods && !(in_array($request->getMethod(), $route->getMethods, true))){
                continue;
            }
            $pattern = $route->getPattern();
            $path = $request->getUri()->getPath();
            if (preg_match("~$pattern~", $path, $matches)){
                $name = $route->getName();
                $controller = $route->getController();
                $action = $route->getAction();
                $params = [1 => '1'];
                $a = new Matches($name, $controller, $action, $params);
                return $a;
            }
        }
    }

}