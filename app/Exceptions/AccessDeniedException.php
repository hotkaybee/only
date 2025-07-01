<?php

namespace App\Exceptions;

use Exception;

class AccessDeniedException extends Exception
{
    public function __construct($message = 'Access denied', $code = 403, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
