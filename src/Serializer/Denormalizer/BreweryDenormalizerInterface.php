<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Brewery;

interface BreweryDenormalizerInterface
{
    public function denormalize(array $data): Brewery;
}