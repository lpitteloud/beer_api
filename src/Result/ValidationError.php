<?php

declare(strict_types=1);

namespace App\Result;

readonly class ValidationError
{
    public function __construct(
        private string $property,
        private string $message
    ) {
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}