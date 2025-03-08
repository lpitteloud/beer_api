<?php

declare(strict_types=1);

namespace App\Controller;

use App\Provider\BreweryProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BreweryStatsController extends AbstractController
{
    public function __construct(
        private readonly BreweryProviderInterface $breweryProvider
    ) {
    }

    public function getCountriesByBreweryCount(): JsonResponse
    {
        $countries = $this->breweryProvider->findCountriesByBreweryCount();

        return $this->json($countries);
    }
}