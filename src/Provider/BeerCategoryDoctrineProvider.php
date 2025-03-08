<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\BeerCategory;
use App\Repository\BeerCategoryRepository;

readonly class BeerCategoryDoctrineProvider implements BeerCategoryProviderInterface
{
    public function __construct(
        private BeerCategoryRepository $beerCategoryRepository
    ) {
    }

    public function findByName(string $name): ?BeerCategory
    {
        return $this->beerCategoryRepository->findOneBy(['name' => $name]);
    }
}
