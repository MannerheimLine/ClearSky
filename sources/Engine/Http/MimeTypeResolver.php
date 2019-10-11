<?php


namespace Engine\Http;


use Psr\Http\Message\ServerRequestInterface;
use SplFileInfo;

class MimeTypeResolver
{
    public function resolve(ServerRequestInterface $request){
        $path = $request->getQueryParams()['url'];
        $info = new SplFileInfo($path);
        $ext = $info->getExtension();
        if (!empty($ext)){
            switch ($ext){
                case 'css' :
                    $contentType = 'text/css';
                    break;
                case 'js' :
                    $contentType = 'application/javascript';
                    break;
                case 'png' :
                    $contentType = 'image/jpeg';
                    break;
            }
            header("Content-type: $contentType; charset: UTF-8");
            echo file_get_contents($path);
        }
    }
}