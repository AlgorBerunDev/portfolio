<?php

namespace App\Exceptions;

class Exceptions extends ExceptionCode
{
    public function __construct($code = 0, $message = null) {
        if(!$message) {
            throw new RenderableException($this->getCodeMessage($code), $code);
        }

        throw new RenderableException($message, $code);
    }
}
