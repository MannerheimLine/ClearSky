<?php


namespace Application\Controllers;


use Zend\Diactoros\Response\HtmlResponse;

class ControllerApplication
{
    public function actionIndex(){
        $html = file_get_contents('storage/page.php') ;
        $response = new HtmlResponse($html);
        return $response;
    }

}