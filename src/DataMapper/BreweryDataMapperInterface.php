<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\Brewery;

interface BreweryDataMapperInterface
{
    public function map(array $data): Brewery;
}
