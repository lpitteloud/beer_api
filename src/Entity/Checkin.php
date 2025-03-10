<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Dto\CheckinInput;
use App\Repository\CheckinRepository;
use App\State\CheckinInputProcessor;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CheckinRepository::class)]
#[ApiResource(operations: [
    new Get(),
    new Post(
        input: CheckinInput::class,
        processor: CheckinInputProcessor::class
    ),
    new Delete(),
    new Patch(),
    new GetCollection()
])]
class Checkin
{
    use TimestampableEntity;

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
