<?php


namespace Application\EMR\PatientCard\Responders;


use Application\Base\AppResponder;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class PatientCardShowResponder extends AppResponder
{

    /**
     * @param ServerRequestInterface $request
     * @param null $payload
     * @return Response
     */
    public function respond(ServerRequestInterface $request, $payload = null): Response
    {
        $this->_template->setTitle('Карта пациента');
        $html = $this->_template->render('patient_card/show.page', $payload);
        return new Response\HtmlResponse($html);
    }
}