<?php


namespace Application\EMR\Talons\Actions;


use Application\EMR\Talons\Domains\AmbulatoryTalon;
use Mpdf\Mpdf;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class AmbulatoryTalonSaveAction implements RequestHandlerInterface
{
    private $_talon;

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
        /**
         * @var Mpdf $pdf
         */
        $cardId = $request->getAttribute('id');
        $pdf = $this->_talon->makePdf($cardId);
        $pdf->Output('storage/file_'.$cardId.'.pdf', 'F');
        /**
         * Можно получить ссылки на файл и передать в респондер, где отрендерится HTML страница с файлами
         * и будет показан только, что созданный например
         */
        return new HtmlResponse('<p>Файл сохранен</p>');
    }
}