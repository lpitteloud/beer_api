<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\BeerStyle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BeerStyle>
 */
class BeerStyleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BeerStyle::class);
    }

    public function findBeerStylesByBeerCount(int $limit): array
    {
        return $this->createQueryBuilder('beerStyle')
            ->select('beerStyle', 'COUNT(beer.id) as beerCount')
            ->leftJoin('beerStyle.beers', 'beer')
            ->groupBy('beerStyle.id')
            ->orderBy('beerCount', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
