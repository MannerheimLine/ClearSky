<?php


namespace Administrator\Users\Responders;


use Administrator\Base\AdminResponder;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class UsersIndexResponder extends AdminResponder
{

    /**
     * @param ServerRequestInterface $request
     * @param null $payload
     * @return Response
     */
    public function respond(ServerRequestInterface $request, $payload = null): Response
    {
        $this->_template->setTitle('Пользователи');
        $html = $this->_template->render('users/index.page', $payload);
        return new Response\HtmlResponse($html);
    }
}