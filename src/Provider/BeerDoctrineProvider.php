<?php

declare(strict_types=1);

namespace App\Provider;

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
