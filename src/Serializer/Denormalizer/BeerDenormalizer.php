<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Beer;

class BeerDenormalizer implements BeerDenormalizerInterface
{
    public function denormalize(array $data): Beer
    {
        return new Beer(
            externalId: $data['id'],
            name: $data['Name'],
            abv: (float)($data['Alcohol By Volume'] ?? 0),
            ibu: (int)($data['International Bitterness Units'] ?? 0)
        );
    }
}
