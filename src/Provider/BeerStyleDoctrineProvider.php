<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\BeerStyle;
use App\Repository\BeerStyleRepository;

readonly class BeerStyleDoctrineProvider implements BeerStyleProviderInterface
{
    private const DEFAULT_LIMIT = 10;

    public function __construct(
        private BeerStyleRepository $beerStyleRepository
    ) {
    }

    public function findByName(string $name): ?BeerStyle
    {
        return $this->beerStyleRepository->findOneBy(['name' => $name]);
    }
}
