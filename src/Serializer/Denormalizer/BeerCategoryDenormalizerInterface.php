<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Entity\BeerCategory;

interface BeerCategoryDenormalizerInterface
{
    public function denormalize(array $data): BeerCategory;
}