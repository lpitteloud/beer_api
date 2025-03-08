<?php

declare(strict_types=1);

namespace App\Handler;

use App\DataMapper\BeerCategoryDataMapperInterface;
use App\DataMapper\BeerDataMapperInterface;
use App\DataMapper\BeerStyleDataMapperInterface;
use App\DataMapper\BreweryDataMapperInterface;
use App\Exception\CsvImportException;
use App\Manager\BeerManagerInterface;
use App\Provider\BeerCategoryProviderInterface;
use App\Provider\BeerStyleProviderInterface;
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
        private BeerManagerInterface $beerManager,
        private BeerStyleDataMapperInterface $beerStyleDataMapper,
        private BeerStyleProviderInterface $beerStyleProvider,
        private BeerCategoryDataMapperInterface $beerCategoryDataMapper,
        private BeerCategoryProviderInterface $beerCategoryProvider
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

        $beers = $breweries = $styles = $categories = [];
        foreach ($records as $index => $record) {
            try {
                $breweryId = $record['brewery_id'] ?? null;
                $styleName = $record['Style'] ?? null;
                $categoryName = $record['Category'] ?? null;

                if (!array_key_exists($styleName, $styles)) {
                    $style = $this->beerStyleProvider->findByName($styleName);

                    if ($style === null) {
                        $style = $this->beerStyleDataMapper->map($record);
                    }

                    $styles[$styleName] = $style;
                }

                $style = $styles[$styleName];

                if (!array_key_exists($categoryName, $categories)) {
                    $category = $this->beerCategoryProvider->findByName($categoryName);

                    if ($category === null) {
                        $category = $this->beerCategoryDataMapper->map($record);
                    }

                    $categories[$categoryName] = $category;
                }

                $category = $categories[$categoryName];

                if (!array_key_exists($breweryId, $breweries)) {
                    $brewery = $this->breweryProvider->findByExternalId($breweryId);

                    if ($brewery === null) {
                        $brewery = $this->breweryDataMapper->map($record);
                    }

                    $breweries[$breweryId] = $brewery;
                }

                $brewery = $breweries[$breweryId] ?? null;

                $beer = $this->beerDataMapper->map($record, $style, $category, $brewery);
                $beers[$beer->getExternalId()] = $beer;
            } catch (\Exception $e) {
                throw new CsvImportException("Error processing row " . ($index+1) . " " . $e->getMessage());
            }
        }

        return $this->beerManager->persistMany($beers);
    }
}