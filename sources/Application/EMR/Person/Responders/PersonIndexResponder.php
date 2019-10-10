<?php

declare(strict_types = 1);

namespace Application\EMR\Person\Responders;


use Application\Base\AppResponder;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class PersonIndexResponder extends AppResponder
{
    /**
     * @param ServerRequestInterface $request
     * @param null $payload
     * @return Response
     */
    public function respond(ServerRequestInterface $request, $payload = null): Response
    {
        $name = 'Mikki';
        $html = require 'sources/Application/Templates/Person/index.page.php';
        return new Response\HtmlResponse($html);
    }
}
