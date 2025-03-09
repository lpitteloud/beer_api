<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CheckinRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CheckinRepository::class)]
#[ApiResource]
class Checkin
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[Assert\NotNull]
        #[Assert\Type('float')]
        #[Assert\PositiveOrZero]
        #[ORM\Column]
        private ?float $rating = null,

        #[Assert\NotNull]
        #[ORM\ManyToOne(inversedBy: 'checkins')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Beer $beer = null,

        #[Assert\NotNull]
        #[ORM\ManyToOne(inversedBy: 'checkins')]
        #[ORM\JoinColumn(nullable: false)]
        private ?User $user = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getBeer(): ?Beer
    {
        return $this->beer;
    }

    public function setBeer(?Beer $beer): static
    {
        $this->beer = $beer;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
