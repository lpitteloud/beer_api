<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Brewery;
use App\Repository\BreweryRepository;

readonly class BreweryDoctrineProvider implements BreweryProviderInterface
{
    private const DEFAULT_LIMIT = 10;

    public function __construct(
        private BreweryRepository $breweryRepository
    ) {
    }

    public function findByExternalId(string $externalId): ?Brewery
    {
        return $this->breweryRepository->findOneBy(['externalId' => $externalId]);
    }

    /**
     * @return Brewery[]
     */
    public function findCountriesByBreweryCount(int $limit = self::DEFAULT_LIMIT): array
    {
        return $this->breweryRepository->findCountriesByBreweryCount($limit);
    }
}
