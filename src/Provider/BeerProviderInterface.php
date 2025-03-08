<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Beer;

interface BeerProviderInterface
{
    public function findByExternalId(string $externalId): ?Beer;

    /**
     * @return Beer[]
     */
    public function findBeersByAlcoholContent(int $limit): array;

    /**
     * @return Beer[]
     */
    public function findMostBitterBeers(int $limit): array;
}
