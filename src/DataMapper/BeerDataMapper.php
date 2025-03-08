<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\Beer;
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

    public function map(array $data, ?Brewery $brewery = null): Beer
    {
        $beerId = $data['id'] ?? null;
        $beer = $this->beerProvider->findByExternalId($beerId);

        if ($beer === null) {
            $beer = $this->beerDenormalizer->denormalize($data);
        }

        $beer->setName($data['Name'] ?? '');
        $beer->setAbv((float)($data['Alcohol By Volume'] ?? 0));
        $beer->setIbu((int)($data['International Bitterness Units'] ?? 0));

        if ($brewery !== null) {
            $beer->setBrewery($brewery);
        }

        return $beer;
    }
}