<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Beer;

class CheckinInput
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Range(min: 0, max: 5)]
        #[Groups(['checkin:write'])]
        private float $rating,

        #[Assert\NotNull]
        #[Groups(['checkin:write'])]
        private ?Beer $beer = null,
    ) {
    }

    public function getRating(): float
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
}