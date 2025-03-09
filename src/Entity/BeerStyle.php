<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BeerStyleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BeerStyleRepository::class)]
class BeerStyle
{
    #[Groups(['beer:read', 'rated_beer:read', 'ranked_style:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[Groups(['beer:read', 'rated_beer:read', 'ranked_style:read'])]
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255)]
        private ?string $name = null,

        /**
         * @var Collection<int, Beer>
         */
        #[ORM\OneToMany(targetEntity: Beer::class, mappedBy: 'style')]
        private Collection $beers = new ArrayCollection()
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $beer->setStyle($this);
        }

        return $this;
    }

    public function removeBeer(Beer $beer): static
    {
        if ($this->beers->removeElement($beer)) {
            // set the owning side to null (unless already changed)
            if ($beer->getStyle() === $this) {
                $beer->setStyle(null);
            }
        }

        return $this;
    }
}
