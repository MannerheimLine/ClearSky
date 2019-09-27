<?php

declare(strict_types = 1);

namespace Engine\Router;

use Engine\Router\DataStructures\Matches;
use Engine\Router\Exceptions\RequestNotMatchedException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Matcher
 * ----------------------------------------------------------------------
 * Парсит соответствия между заданными маршрутами и пришедшим адресом URL
 * ----------------------------------------------------------------------
 * @package Engine\Router
 */

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
     * @throws RequestNotMatchedException
     */
    public function match(ServerRequestInterface $request) : Matches {
        /**
         * Проход по маршрутам если таковые имеются
         */
        foreach ($this->_routes->getRoutes() as $route){
            //Фильтрую по методу запроса отсекая лишние
            if ($route->getMethods && !(in_array($request->getMethod(), $route->getMethods, true))){
                continue;
            }
            /**
             * Подменяю {Плейсхолдеры} на регулярные выражения
             * Исходная строка: '/catalog/{id}/view/{number}'
             * Возвращщает: '/catalog/\d+/view/\d+'
             */
            $pattern = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use ($route) {
                $argument = $matches[1];
                $replace = $route->getAttributes()[$argument] ?? '[^}]+';
                return '(?P<'. $argument. '>' .$replace . ')';
            }, $route->getPattern());
            /**
             * Сравнение полученного шаблона с URL по регулярному выражению
             */
            $path = $request->getUri()->getPath();
            if (preg_match("~$pattern~", $path, $matches)){
                $name = $route->getName();
                $controller = $route->getController();
                $action = $route->getAction();
                $attributes = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return new Matches($name, $controller, $action, $attributes);
            }
        }
        throw new RequestNotMatchedException($request);
    }

}