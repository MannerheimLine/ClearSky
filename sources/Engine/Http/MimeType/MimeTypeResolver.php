<?php

namespace Engine\Http\MimeType;


use Engine\Http\MimeType\Exceptions\UnknownMimeTypeException;
use Psr\Http\Message\ServerRequestInterface;
use SplFileInfo;

/**
 * Решает проблему некоректоного Content Type для некоторых MIME
 * -------------------------------------------------------------
 *
 * Class MimeTypeResolver
 * @package Engine\Http\MimeType
 */
class MimeTypeResolver
{
    private $_mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'tif' => 'image/tiff',
        'ico' => 'image/x-icon',
        'bmp' => 'image/bmp',
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'pdf' => 'application/pdf'
    ];

    /**
     * Когда подгружаю с собственного сервера файлы, идет неверный Content Type
     * Данный метод и класс решает проблему некорректоно Content Type
     * ------------------------------------------------------------------------
     * @param ServerRequestInterface $request
     * @throws UnknownMimeTypeException
     */
    public function resolve(ServerRequestInterface $request) : void {
        $path = $request->getQueryParams()['url'];
        $fileExtension = (new SplFileInfo($path))->getExtension();
        if (!empty($fileExtension)){
            $contentType = $this->_mimeTypes[$fileExtension];
            if (isset($contentType)){
                header("Content-type: $contentType; charset: UTF-8");
                echo file_get_contents($path);
            }else{
                throw new UnknownMimeTypeException('Not found extension ' . $fileExtension);
            }
        }
    }
}