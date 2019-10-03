<?php


namespace Application\Blog\Action;


use Application\Base\Action;
use Application\Blog\Domain\Injectable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CategoryIndexAction extends Action implements RequestHandlerInterface
{
    private $injectable;
    public function __construct(Injectable $injectable)
    {
        $this->injectable = $injectable;
        parent::__construct();
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = $request->getAttributes()['id'];
        $number = $request->getAttributes()['number'];
        //$response = new JsonResponse(['id' => $id, 'number' => $number], 200);
        $response = $this->injectable->handle();
        /** @var ResponseInterface $response */
        $response = $response->withAddedHeader('Protected-Variable', $this->_variable);
        $response = $response->withAddedHeader('Another-Header', $this->AnotherHeader());
        $response = $response->withAddedHeader('client-ip', $request->getAttributes()['client-ip']);
        return $response;
    }

}