<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Card\Responders;


use Application\Base\AppResponder;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class PatientCardIndexResponder extends AppResponder
{
    /**
     * @param ServerRequestInterface $request
     * @param null $payload
     * @return Response
     */
    public function respond(ServerRequestInterface $request, $payload = null): Response
    {
        return new Response\RedirectResponse('/app/patient-card/show/'.$payload);
    }
}
