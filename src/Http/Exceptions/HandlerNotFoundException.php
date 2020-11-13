<?php


namespace HttpServer\Http\Exceptions;


use Exception;
use Throwable;

class HandlerNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("Http server handler is not found.");
    }
}