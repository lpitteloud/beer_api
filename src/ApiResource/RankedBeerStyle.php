<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\BeerStatsController;
use App\Entity\BeerStyle;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'RankedBeerStyle',
    operations: [
        new GetCollection(
            uriTemplate: '/rankings/beers/styles/by-beer-count',
            controller: BeerStatsController::class . '::getBeerStylesByCount',
        ),
    ],
    normalizationContext: ['groups' => ['ranked_style:read']]
)]
readonly class RankedBeerStyle
{
    public function __construct(
        #[Groups(['ranked_style:read'])]
        private BeerStyle $beerStyle,
        #[Groups(['ranked_style:read'])]
        private int $beerCount
    ) {
    }

    public function getBeerStyle(): BeerStyle
    {
        return $this->beerStyle;
    }

    public function getBeerCount(): int
    {
        return $this->beerCount;
    }
}
