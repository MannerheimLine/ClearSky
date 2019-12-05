<?php

declare(strict_types = 1);

namespace Application\EMR\Talons\Actions;


use Application\EMR\Talons\Domains\AmbulatoryTalon;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class AmbulatoryTalonShowAction
 * @package Application\EMR\Talons\Actions
 */
class AmbulatoryTalonShowAction implements RequestHandlerInterface
{
    private $_talon;

    /**
     * AmbulatoryTalonShowAction constructor.
     * @param AmbulatoryTalon $talon
     */
    public function __construct(AmbulatoryTalon $talon)
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
        $cardId = $request->getAttribute('id');
        $pdf = $this->_talon->makePdf((int)$cardId);
        $pdf->Output('Talon.pdf', 'I');
    }
}
