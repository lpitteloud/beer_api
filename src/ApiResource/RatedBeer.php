<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\BeerStatsController;
use App\Entity\Beer;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'RatedBeer',
    operations: [
        new GetCollection(
            uriTemplate: '/rankings/beers/highest-rated',
            controller: BeerStatsController::class . '::getHighestRatedBeers',
        )
    ],
    normalizationContext: ['groups' => ['rated_beer:read']]
)]
readonly class RatedBeer
{
    public function __construct(
        #[Groups(['rated_beer:read'])]
        private Beer $beer,
        #[Groups(['rated_beer:read'])]
        private float $averageRating
    ) {
    }

    public function getBeer(): Beer
    {
        return $this->beer;
    }

    public function getAverageRating(): float
    {
        return $this->averageRating;
    }
}
