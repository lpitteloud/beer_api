<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Brewery;
use App\Repository\BreweryRepository;

readonly class BreweryDoctrineProvider implements BreweryProviderInterface
{
    public function __construct(
        private BreweryRepository $breweryRepository
    ) {
    }

    public function findByExternalId(string $externalId): ?Brewery
    {
        return $this->breweryRepository->findOneBy(['externalId' => $externalId]);
    }
}
