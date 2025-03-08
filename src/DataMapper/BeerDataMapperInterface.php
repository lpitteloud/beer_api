<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\Beer;
use App\Entity\Brewery;

interface BeerDataMapperInterface
{
    public function map(array $data, ?Brewery $brewery = null): Beer;
}
