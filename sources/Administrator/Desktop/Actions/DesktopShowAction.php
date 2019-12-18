<?php


namespace Administrator\Desktop\Actions;


use Administrator\Base\AdminAction;
use Administrator\Desktop\Responders\DesktopShowResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DesktopShowAction extends AdminAction implements RequestHandlerInterface
{
    public function __construct(DesktopShowResponder $responder)
    {
        $this->_responder = $responder;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->_responder->respond($request);
        return $response;
    }
}