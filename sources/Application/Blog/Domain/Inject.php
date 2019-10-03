<?php


namespace Application\Blog\Domain;


use Zend\Diactoros\Response\HtmlResponse;

class Inject implements Injectable
{
    private $data;
    public function __construct(DataProvider $dataProvider)
    {
        $this->data = $dataProvider->execute();
    }

    public function handle()
    {
        return new HtmlResponse($this->data);
    }
}