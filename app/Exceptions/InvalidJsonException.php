<?php

namespace App\Exceptions;

use Exception;

class InvalidJsonException extends Exception
{
    public function __construct($message = null, $code = null) {
        parent::__construct("Json invalid", 422);
        if($message != null) {
            $this->message = $message;
        }
        if($code != null) {
            $this->code = $code;
        }
    }

}