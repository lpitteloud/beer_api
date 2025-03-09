<?php

declare(strict_types=1);

namespace App\Provider;

use App\ApiResource\RankedBeerStyle;
use App\Entity\BeerStyle;

interface BeerStyleProviderInterface
{
    public function findByName(string $name): ?BeerStyle;

    /**
     * @return RankedBeerStyle[]
     */
    public function findBeerStylesByBeerCount(int $limit): array;
}
