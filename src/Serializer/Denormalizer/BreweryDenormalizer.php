<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Brewery;

class BreweryDenormalizer implements BreweryDenormalizerInterface
{
    public function denormalize(array $data): Brewery
    {
        return new Brewery(
            name: $data['Brewer'],
            country: $data['Country'],
            externalId: $data['brewery_id']
        );
    }
}