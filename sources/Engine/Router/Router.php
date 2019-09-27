<?php

declare(strict_types = 1);

namespace Engine\Router;


use Engine\Router\DataStructures\Matches;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    private $_matches;

    public function __construct(Matches $matches)
    {
        $this->_matches = $matches;
    }

    /**
     * Запуск маршрутизации
     * --------------------------------------
     * @param ServerRequestInterface $request
     */
    public function run(ServerRequestInterface$request){
        $controller = $this->_matches->getController();
        $action = $this->_matches->getAction();
        $attributes = $this->_matches->getAttributes();
        //Добавление параметров в запрос, для удобной дальнейшей работы с полным запросом
        foreach ($attributes as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }
        //Запуск
        return (new $controller())->$action($request);
    }

}