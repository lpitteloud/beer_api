<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\BeerCategory;

interface BeerCategoryDataMapperInterface
{
    public function map(array $data): BeerCategory;
}
