<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\BeerStyle;

class BeerStyleDenormalizer implements BeerStyleDenormalizerInterface
{
    public function denormalize(array $data): BeerStyle
    {
        return new BeerStyle(
            name: $data['Style']
        );
    }
}