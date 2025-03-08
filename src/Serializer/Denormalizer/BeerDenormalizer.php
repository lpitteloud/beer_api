<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Beer;

class BeerDenormalizer implements BeerDenormalizerInterface
{
    public function denormalize(array $data): Beer
    {
        return new Beer(
            name: $data['Name'],
            externalId: $data['id']
        );
    }
}
