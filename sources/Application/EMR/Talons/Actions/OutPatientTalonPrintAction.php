<?php


namespace Application\EMR\Talons\Actions;


use Application\EMR\Talons\Domains\OutpatientTalon;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class OutPatientTalonPrintAction implements RequestHandlerInterface
{
    private $_talon;

    public function __construct(OutpatientTalon $talon)
    {
        $this->_talon = $talon;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $pdf = $this->_talon->makePdf(1);
        $pdf->Output('file.pdf', 'I');
    }
}