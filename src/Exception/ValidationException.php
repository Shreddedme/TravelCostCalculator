<?php

namespace App\Exception;

use Exception;

class ValidationException extends Exception
{
    private array $errors;
    public function __construct(array $errors)
    {
        $message = implode(', ', $errors);
        parent::__construct($message);
        $this->errors = $errors;
    }

    public function getValidationErrors(): array
    {
        return $this->errors;
    }
}