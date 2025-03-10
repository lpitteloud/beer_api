<?php

declare(strict_types=1);

namespace App\Controller;

use App\Provider\BeerProviderInterface;
use App\Provider\BeerStyleProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BeerStatsController extends AbstractController
{
    public function __construct(
        private readonly BeerProviderInterface $beerProvider,
        private readonly BeerStyleProviderInterface $beerStyleProvider
    ) {
    }

    public function getHighestRatedBeers(Request $request): JsonResponse
    {
        $limit = $request->query->getInt('limit', 10);
        $beers = $this->beerProvider->findHighestRatedBeers($limit);

        return $this->json($beers);
    }

    public function getMostBitterBeers(Request $request): JsonResponse
    {
        $limit = $request->query->getInt('limit', 10);
        $beers = $this->beerProvider->findMostBitterBeers($limit);

        return $this->json($beers);
    }

    public function getBeerStylesByCount(Request $request): JsonResponse
    {
        $limit = $request->query->getInt('limit', 10);
        $styles = $this->beerStyleProvider->findBeerStylesByBeerCount($limit);

        return $this->json($styles);
    }

    public function getBeersByAlcoholContent(Request $request): JsonResponse
    {
        $limit = $request->query->getInt('limit', 10);
        $beers = $this->beerProvider->findBeersByAlcoholContent($limit);

        return $this->json($beers);
    }
}