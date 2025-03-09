<?php

declare(strict_types=1);

namespace App\Provider;

use App\ApiResource\RatedBeer;
use App\Entity\Beer;
use App\Repository\BeerRepository;

readonly class BeerDoctrineProvider implements BeerProviderInterface
{
    private const DEFAULT_LIMIT = 10;

    public function __construct(
        private BeerRepository $beerRepository
    ) {
    }

    public function findByExternalId(string $externalId): ?Beer
    {
        return $this->beerRepository->findOneBy(['externalId' => $externalId]);
    }

    /**
     * @return RatedBeer[]
     */
    public function findHighestRatedBeers(int $limit = self::DEFAULT_LIMIT): array
    {
        $results = $this->beerRepository->findHighestRatedBeers($limit);

        $ratedBeers = [];

        foreach ($results as $result) {
            $beer = $result[0];
            $avgRating = (float)$result['averageRating'] ?: 0.0;
            $ratedBeers[] = new RatedBeer($beer, $avgRating);
        }

        return $ratedBeers;
    }

    /**
     * @return Beer[]
     */
    public function findBeersByAlcoholContent(int $limit = self::DEFAULT_LIMIT): array
    {
        return $this->beerRepository->findBeersByAlcoholContent($limit);
    }

    public function findMostBitterBeers(int $limit = self::DEFAULT_LIMIT): array
    {
        return $this->beerRepository->findMostBitterBeers($limit);
    }
}
