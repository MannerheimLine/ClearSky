<?php


namespace Engine\Router\Exceptions;


use Psr\Http\Message\ServerRequestInterface;

class RequestNotMatchedException extends \Exception
{
    private $_request;

    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct('Match Not Found');
        $this->_request = $request;
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->_request;
    }

}