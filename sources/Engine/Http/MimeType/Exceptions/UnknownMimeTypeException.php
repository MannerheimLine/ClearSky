<?php


namespace Engine\Http\MimeType\Exceptions;


use Throwable;

class UnknownMimeTypeException extends \LogicException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message);
    }

}