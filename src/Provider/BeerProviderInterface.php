<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Beer;

interface BeerProviderInterface
{
    public function findByExternalId(string $externalId): ?Beer;
}
