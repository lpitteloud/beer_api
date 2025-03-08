<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\BeerStyle;

interface BeerStyleDenormalizerInterface
{
    public function denormalize(array $data): BeerStyle;
}