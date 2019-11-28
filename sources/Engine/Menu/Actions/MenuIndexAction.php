<?php


namespace Engine\Menu\Actions;


use Engine\Menu\Domains\Menu;
use Engine\Menu\Responders\MenuIndexResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MenuIndexAction implements RequestHandlerInterface
{
    private $_menu;
    private $_responder;

    public function __construct(Menu $menu, MenuIndexResponder $responder)
    {
        $this->_menu = $menu;
        $this->_responder = $responder;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $menuId = $request->getParsedBody()['menuId'];
        $payload = $this->_menu->getMenuLinks($menuId);
        $response = $this->_responder->respond($payload);
        return$response;
    }
}