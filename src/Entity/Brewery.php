<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\BreweryStatsController;
use App\Repository\BreweryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BreweryRepository::class)]
#[ApiResource(operations: [
    new Get(),
    new Post(),
    new Patch(),
    new Delete(),
    new GetCollection(),
    new GetCollection(
        uriTemplate: '/rankings/countries/by-brewery-count',
        controller: BreweryStatsController::class . '::getCountriesByBreweryCount',
    )
])]
class Brewery
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255)]
        private ?string $externalId = null,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255)]
        private ?string $name = null,

        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255, nullable: true)]
        private ?string $streetAddress = null,

        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255, nullable: true)]
        private ?string $city = null,

        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255, nullable: true)]
        private ?string $zipCode = null,

        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255, nullable: true)]
        private ?string $country = null,

        /**
         * @var Collection<int, Beer>
         */
        #[ORM\OneToMany(targetEntity: Beer::class, mappedBy: 'brewery')]
        private Collection $beers = new ArrayCollection()
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStreetAddress(): ?string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(?string $streetAddress): static
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Beer>
     */
    public function getBeers(): Collection
    {
        return $this->beers;
    }

    public function addBeer(Beer $beer): static
    {
        if (!$this->beers->contains($beer)) {
            $this->beers->add($beer);
            $beer->setBrewery($this);
        }

        return $this;
    }

    public function removeBeer(Beer $beer): static
    {
        if ($this->beers->removeElement($beer)) {
            // set the owning side to null (unless already changed)
            if ($beer->getBrewery() === $this) {
                $beer->setBrewery(null);
            }
        }

        return $this;
    }
}
