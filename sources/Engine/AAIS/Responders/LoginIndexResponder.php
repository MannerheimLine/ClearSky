<?php

declare(strict_types = 1);

namespace Engine\AAIS\Responders;


use Engine\AAIS\Base\LoginTemplate;
use Zend\Diactoros\Response;

class LoginIndexResponder
{
    protected $_template;

    public function __construct()
    {
        $this->_template = new LoginTemplate();
    }

    /**
     * Подгрузка страницы авторизации
     *
     * @return Response
     */
    public function respond() : Response {
        $this->_template->setTitle('Авторизация');
        $html = $this->_template->render();
        return new Response\HtmlResponse($html);
    }
}