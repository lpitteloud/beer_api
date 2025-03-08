<?php

declare(strict_types=1);

namespace App\Result;

class EntityValidationResult
{
    public function __construct(
        private readonly string $identifier,
        /**
         * @var ValidationError[]
         */
        private array $errors = []
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function addError(string $property, string $message): static
    {
        $this->errors[] = new ValidationError($property, $message);

        return $this;
    }

    /**
     * @return ValidationError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}