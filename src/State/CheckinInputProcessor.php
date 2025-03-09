<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\CheckinInput;
use App\Entity\Checkin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

readonly class CheckinInputProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security
    ) {
    }

    /**
     * @param CheckinInput $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): object
    {
        $currentUser = $this->security->getUser();
        if (!$currentUser) {
            throw new AccessDeniedHttpException();
        }

        $beer = $data->getBeer();

        $checkin = new Checkin(
            rating: $data->getRating(),
            beer: $beer,
            user: $currentUser,
        );

        $this->entityManager->persist($checkin);
        $this->entityManager->flush();

        return $checkin;
    }
}