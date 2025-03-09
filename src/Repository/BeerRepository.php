<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Beer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Beer>
 */
class BeerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beer::class);
    }

    public function findHighestRatedBeers(int $limit): array
    {
        return $this->createQueryBuilder('beer')
            ->select('beer', 'AVG(checkin.rating) as averageRating')
            ->leftJoin('beer.checkins', 'checkin')
            ->groupBy('beer.id')
            ->orderBy('averageRating', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findMostBitterBeers(int $limit): array
    {
        return $this->createQueryBuilder('beer')
            ->where('beer.ibu IS NOT NULL')
            ->orderBy('beer.ibu', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findStylesByBeerCount(): array
    {
        return $this->createQueryBuilder('beer')
            ->select('beer.style as style, COUNT(beer.id) as count')
            ->groupBy('beer.style')
            ->orderBy('count', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findBeersByAlcoholContent(int $limit): array
    {
        return $this->createQueryBuilder('beer')
            ->where('beer.abv IS NOT NULL')
            ->orderBy('beer.abv', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
