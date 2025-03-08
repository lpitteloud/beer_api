<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Beer;
use App\Result\EntityValidationResult;
use App\Result\PersistenceResult;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class BeerManager implements BeerManagerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    /**
     * @param Beer[] $beers
     */
    public function persistMany(array $beers): PersistenceResult
    {
        $result = new PersistenceResult();
        $validBeers = [];

        foreach ($beers as $beer) {
            $entityResult = new EntityValidationResult($beer->getName());

            $violations = $this->validator->validate($beer);

            if (count($violations) > 0) {
                foreach ($violations as $violation) {
                    $entityResult->addError(
                        $violation->getPropertyPath(),
                        $violation->getMessage()
                    );
                }
            } else {
                $validBeers[] = $beer;
                $this->entityManager->persist($beer);
            }

            $result->addValidationResult($entityResult);
        }

        if (!empty($validBeers)) {
            $this->entityManager->flush();
        }

        return $result;
    }
}