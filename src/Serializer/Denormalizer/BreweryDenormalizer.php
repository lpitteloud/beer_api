<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Brewery;

class BreweryDenormalizer implements BreweryDenormalizerInterface
{
    public function denormalize(array $data): Brewery
    {
        return new Brewery(
            externalId: $data['brewery_id'],
            name: $data['Brewer'],
            streetAddress: $data['Address'],
            city: $data['City'],
            country: $data['Country']
        );
    }
}