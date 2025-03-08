<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\BeerStyle;

interface BeerStyleDataMapperInterface
{
    public function map(array $data): BeerStyle;
}
