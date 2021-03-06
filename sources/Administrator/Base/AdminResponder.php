<?php

declare(strict_types = 1);

namespace Administrator\Base;


use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

abstract class AdminResponder
{
    protected $_template;

    public function __construct()
    {
        $this->_template = new AdminTemplate();
    }

    /**
     * @param ServerRequestInterface $request
     * @param null $payload
     * @return Response
     */
    abstract public function respond(ServerRequestInterface $request, $payload = null) : Response;

}