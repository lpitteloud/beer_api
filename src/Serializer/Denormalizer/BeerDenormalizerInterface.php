<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\Beer;

interface BeerDenormalizerInterface
{
    public function denormalize(array $data): Beer;
}