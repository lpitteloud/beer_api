<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\Brewery;
use App\Provider\BreweryProviderInterface;
use App\Serializer\Denormalizer\BreweryDenormalizerInterface;

readonly class BreweryDataMapper implements BreweryDataMapperInterface
{
    public function __construct(
        private BreweryProviderInterface $breweryProvider,
        private BreweryDenormalizerInterface $breweryDenormalizer
    ) {
    }

    public function map(array $data): Brewery
    {
        $breweryId = $data['brewery_id'] ?? null;
        $brewery = $this->breweryProvider->findByExternalId($breweryId);

        if ($brewery !== null) {
            return $brewery;
        }

        return $this->breweryDenormalizer->denormalize($data);
    }
}