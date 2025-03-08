<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Brewery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Brewery>
 */
class BreweryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brewery::class);
    }

    /**
     * @return Brewery[]
     */
    public function findCountriesByBreweryCount(int $limit): array
    {
        return $this->createQueryBuilder('brewery')
            ->select('brewery.country as country, COUNT(brewery.id) as count')
            ->groupBy('brewery.country')
            ->orderBy('count', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
