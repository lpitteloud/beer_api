<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\Beer;
use App\Entity\BeerCategory;
use App\Entity\BeerStyle;
use App\Entity\Brewery;
use App\Provider\BeerProviderInterface;
use App\Serializer\Denormalizer\BeerDenormalizerInterface;

readonly class BeerDataMapper implements BeerDataMapperInterface
{
    public function __construct(
        private BeerProviderInterface $beerProvider,
        private BeerDenormalizerInterface $beerDenormalizer
    ) {
    }

    public function map(array $data, BeerStyle $beerStyle, BeerCategory $beerCategory, ?Brewery $brewery = null): Beer
    {
        $beerId = $data['id'] ?? null;
        $beer = $this->beerProvider->findByExternalId($beerId);

        if ($beer !== null) {
            return $beer;
        }

        $beer = $this->beerDenormalizer->denormalize($data);
        $beer
            ->setBrewery($brewery)
            ->setStyle($beerStyle)
            ->setCategory($beerCategory)
        ;

        return $beer;
    }
}