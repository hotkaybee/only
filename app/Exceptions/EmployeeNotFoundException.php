<?php

namespace App\Exceptions;

use Exception;

class EmployeeNotFoundException extends Exception
{
    public function __construct($message = 'Employee not found', $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
