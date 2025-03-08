<?php

declare(strict_types=1);

namespace App\Manager;

use App\Result\PersistenceResult;

interface BeerManagerInterface
{
    public function persistMany(array $beers): PersistenceResult;
}