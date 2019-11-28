<?php

namespace Engine\Base;


use Aura\Router\RouterContainer;
use DI\Container;

/**
 * Фасад приложения
 *
 * Class App
 * @package Engine\Base
 */
class App
{
    private function __construct(){}

    private function __clone(){}

    /**
     * @var Container $_container
     */
    private static $_container;

    /**
     * @var RouterContainer $_router
     */
    private static $_router;

    public static function initContainer($container) : void {
        self::$_container = $container;
    }

    public static function initRouter($router) : void {
        self::$_router = $router;
    }

    /**
     * Генерирует ссылку используя Aura Router
     *
     * @param string $uriName
     * @param array $data
     * @return string
     */
    public static function generateUri(string $uriName, array $data = []) : string {

        return self::$_router->getGenerator()->generate($uriName, $data);
    }

    /**
     * Вернет объект контейнера, с определенными на этапе инициализации зависимостями
     *
     * @param $needle
     * @return mixed
     */
    public static function getDependency($needle) {
        return self::$_container->get($needle);
    }

    /**
     * Пока не реализована, но вдруг мне потребуется внутри модлей проинжектить зависимость при то чтобы она
     * стала доступна в жругом месте. Делаю через фасад
     */
    public static function injectOn(){}

}