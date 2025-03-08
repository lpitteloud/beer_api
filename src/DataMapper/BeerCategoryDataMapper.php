<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\BeerCategory;
use App\Provider\BeerCategoryProviderInterface;
use App\Serializer\Denormalizer\BeerCategoryDenormalizerInterface;

readonly class BeerCategoryDataMapper implements BeerCategoryDataMapperInterface
{
    public function __construct(
        private BeerCategoryDenormalizerInterface $beerCategoryDenormalizer,
        private BeerCategoryProviderInterface $beerCategoryProvider
    ) {
    }

    public function map(array $data): BeerCategory
    {
        $beerCategory = $this->beerCategoryProvider->findByName($data['Category']);

        if ($beerCategory !== null) {
            return $beerCategory;
        }

        return $this->beerCategoryDenormalizer->denormalize($data);
    }
}
