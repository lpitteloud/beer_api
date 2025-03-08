<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\BeerStatsController;
use App\Repository\BeerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BeerRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(),
        new Delete(),
        new Patch(),
        new GetCollection(),
        new GetCollection(
            uriTemplate: '/rankings/beers/by-alcohol',
            controller: BeerStatsController::class . '::getBeersByAlcoholContent',
        ),
        new GetCollection(
            uriTemplate: '/rankings/beers/most-bitter',
            controller: BeerStatsController::class . '::getMostBitterBeers',
        )
    ],
    normalizationContext: ['groups' => ['beer']],
)]
class Beer
{
    #[Groups('beer')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[Groups('beer')]
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255)]
        private ?string $externalId = null,

        #[Groups('beer')]
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255)]
        private ?string $name = null,

        #[Groups('beer')]
        #[ORM\Column]
        private ?float $abv = null,

        #[Groups('beer')]
        #[ORM\Column]
        private ?int $ibu = null,

        #[Groups('beer')]
        #[Assert\Valid]
        #[ORM\ManyToOne(inversedBy: 'beers', cascade: ['persist'])]
        private ?Brewery $brewery = null,

        #[Groups('beer')]
        #[Assert\Valid]
        #[ORM\ManyToOne(inversedBy: 'beers', cascade: ['persist'])]
        #[ORM\JoinColumn(nullable: false)]
        private ?BeerStyle $style = null,

        #[Groups('beer')]
        #[Assert\Valid]
        #[ORM\ManyToOne(inversedBy: 'beers', cascade: ['persist'])]
        #[ORM\JoinColumn(nullable: false)]
        private ?BeerCategory $category = null,

        /**
         * @var Collection<int, Checkin>
         */
        #[ORM\OneToMany(targetEntity: Checkin::class, mappedBy: 'beer', orphanRemoval: true)]
        private Collection $checkins = new ArrayCollection()
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

    public function getAbv(): ?float
    {
        return $this->abv;
    }

    public function setAbv(float $abv): static
    {
        $this->abv = $abv;

        return $this;
    }

    public function getIbu(): ?int
    {
        return $this->ibu;
    }

    public function setIbu(int $ibu): static
    {
        $this->ibu = $ibu;

        return $this;
    }

    public function getBrewery(): ?Brewery
    {
        return $this->brewery;
    }

    public function setBrewery(?Brewery $brewery): static
    {
        $this->brewery = $brewery;

        return $this;
    }

    /**
     * @return Collection<int, Checkin>
     */
    public function getCheckins(): Collection
    {
        return $this->checkins;
    }

    public function addCheckin(Checkin $checkin): static
    {
        if (!$this->checkins->contains($checkin)) {
            $this->checkins->add($checkin);
            $checkin->setBeer($this);
        }

        return $this;
    }

    public function removeCheckin(Checkin $checkin): static
    {
        // set the owning side to null (unless already changed)
        if ($this->checkins->removeElement($checkin) && $checkin->getBeer() === $this) {
            $checkin->setBeer(null);
        }

        return $this;
    }

    public function getStyle(): ?BeerStyle
    {
        return $this->style;
    }

    public function setStyle(?BeerStyle $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getCategory(): ?BeerCategory
    {
        return $this->category;
    }

    public function setCategory(?BeerCategory $category): static
    {
        $this->category = $category;

        return $this;
    }
}
