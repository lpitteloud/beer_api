<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\Beer;
use App\Entity\BeerCategory;
use App\Entity\BeerStyle;
use App\Entity\Brewery;

interface BeerDataMapperInterface
{
    public function map(array $data, BeerStyle $beerStyle, BeerCategory $beerCategory, ?Brewery $brewery = null): Beer;
}
