<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Beer;
use App\Repository\BeerRepository;

readonly class BeerDoctrineProvider implements BeerProviderInterface
{
    public function __construct(
        private BeerRepository $beerRepository
    ) {
    }

    public function findByExternalId(string $externalId): ?Beer
    {
        return $this->beerRepository->findOneBy(['externalId' => $externalId]);
    }
}
