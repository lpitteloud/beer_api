<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Brewery;

interface BreweryProviderInterface
{
    public function findByExternalId(string $externalId): ?Brewery;
}
