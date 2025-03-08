<?php

declare(strict_types=1);

namespace App\Handler;

use App\DataMapper\BeerDataMapperInterface;
use App\DataMapper\BreweryDataMapperInterface;
use App\Exception\CsvImportException;
use App\Manager\BeerManagerInterface;
use App\Provider\BreweryProviderInterface;
use App\Result\PersistenceResult;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

readonly class CsvImportHandler
{
    public function __construct(
        private BreweryDataMapperInterface $breweryDataMapper,
        private BeerDataMapperInterface $beerDataMapper,
        private BreweryProviderInterface $breweryProvider,
        private BeerManagerInterface $beerManager
    ) {
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     * @throws CsvImportException
     */
    public function import(string $filePath): PersistenceResult
    {
        $csv = Reader::createFromPath($filePath);
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');

        $records = $csv->getRecords();

        $beers = $breweries = [];
        foreach ($records as $index => $record) {
            try {
                $breweryId = $record['brewery_id'] ?? null;

                if (!array_key_exists($breweryId, $breweries)) {
                    $brewery = $this->breweryProvider->findByExternalId($breweryId);

                    if ($brewery === null) {
                        $brewery = $this->breweryDataMapper->map($record);
                    }

                    $breweries[$breweryId] = $brewery;
                }

                $brewery = $breweries[$breweryId] ?? null;

                $beer = $this->beerDataMapper->map($record, $brewery);
                $beers[$beer->getExternalId()] = $beer;
            } catch (\Exception $e) {
                throw new CsvImportException("Error processing row " . ($index+1) . " " . $e->getMessage());
            }
        }

        return $this->beerManager->persistMany($beers);
    }
}