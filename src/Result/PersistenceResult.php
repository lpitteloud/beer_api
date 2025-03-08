<?php

declare(strict_types=1);

namespace App\Result;

class PersistenceResult
{
    /**
     * @var EntityValidationResult[]
     */
    private array $validationResults = [];
    private int $totalCount = 0;
    private int $validCount = 0;
    private int $invalidCount = 0;

    public function addValidationResult(EntityValidationResult $result): static
    {
        $this->validationResults[] = $result;
        $this->totalCount++;

        if ($result->hasErrors()) {
            $this->invalidCount++;
        } else {
            $this->validCount++;
        }

        return $this;
    }

    /**
     * @return EntityValidationResult[]
     */
    public function getValidationResults(): array
    {
        return $this->validationResults;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function getValidCount(): int
    {
        return $this->validCount;
    }

    public function getInvalidCount(): int
    {
        return $this->invalidCount;
    }

    public function hasErrors(): bool
    {
        return $this->invalidCount > 0;
    }
}