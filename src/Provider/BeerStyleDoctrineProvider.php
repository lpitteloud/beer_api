<?php

declare(strict_types=1);

namespace App\Provider;

use App\ApiResource\RankedBeerStyle;
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

    public function findBeerStylesByBeerCount(int $limit = self::DEFAULT_LIMIT): array
    {
        $results = $this->beerStyleRepository->findBeerStylesByBeerCount($limit);

        $rankedStyles = [];

        foreach ($results as $result) {
            $beerStyle = $result[0];
            $beerCount = (int)$result['beerCount'];
            $rankedStyles[] = new RankedBeerStyle($beerStyle, $beerCount);
        }

        return $rankedStyles;
    }
}
