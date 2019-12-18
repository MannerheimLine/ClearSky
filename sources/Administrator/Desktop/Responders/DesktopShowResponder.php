<?php


namespace Administrator\Desktop\Responders;


use Administrator\Base\AdminResponder;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class DesktopShowResponder extends AdminResponder
{

    /**
     * @param ServerRequestInterface $request
     * @param null $payload
     * @return Response
     */
    public function respond(ServerRequestInterface $request, $payload = null): Response
    {
        $this->_template->setTitle('Рабочий стол');
        $html = $this->_template->render('desktop/show.page', $payload);
        return new Response\HtmlResponse($html);
    }
}