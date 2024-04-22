<?php

namespace App\ErrorHandling;

class ErrorResponse
{
    private ?array $errors = null;

    public function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }
}
