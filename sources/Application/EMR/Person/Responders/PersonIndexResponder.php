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
        $this->_template->setTitle('Главная');
        $html = $this->_template->render('person/index.page', $payload);
        return new Response\HtmlResponse($html);
    }
}
