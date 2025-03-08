<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\BeerCategory;

interface BeerCategoryProviderInterface
{
    public function findByName(string $name): ?BeerCategory;
}
