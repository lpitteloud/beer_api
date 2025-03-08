<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\BeerStyle;
use App\Provider\BeerStyleProviderInterface;
use App\Serializer\Denormalizer\BeerStyleDenormalizerInterface;

readonly class BeerStyleDataMapper implements BeerStyleDataMapperInterface
{
    public function __construct(
        private BeerStyleDenormalizerInterface $beerStyleDenormalizer,
        private BeerStyleProviderInterface $beerStyleProvider
    ) {
    }

    public function map(array $data): BeerStyle
    {
        $beerStyle = $this->beerStyleProvider->findByName($data['Style']);

        if ($beerStyle !== null) {
            return $beerStyle;
        }

        return $this->beerStyleDenormalizer->denormalize($data);
    }
}
