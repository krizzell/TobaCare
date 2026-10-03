<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    public function __construct(
        public string $errorCode,
        string $message,
        public int $statusCode = 400,
        public array $extra = []
    ) {
        parent::__construct($message);
    }
}
