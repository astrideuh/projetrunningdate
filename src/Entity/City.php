<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $Country = null;

    /**
     * @var Collection<int, Endroits>
     */
    #[ORM\OneToMany(targetEntity: Endroits::class, mappedBy: 'City')]
    private Collection $endroits;

    public function __construct()
    {
        $this->endroits = new ArrayCollection();
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

    public function getCountry(): ?Country
    {
        return $this->Country;
    }

    public function setCountry(?Country $Country): static
    {
        $this->Country = $Country;

        return $this;
    }

    /**
     * @return Collection<int, Endroits>
     */
    public function getEndroits(): Collection
    {
        return $this->endroits;
    }

    public function addEndroit(Endroits $endroit): static
    {
        if (!$this->endroits->contains($endroit)) {
            $this->endroits->add($endroit);
            $endroit->setCity($this);
        }

        return $this;
    }

    public function removeEndroit(Endroits $endroit): static
    {
        if ($this->endroits->removeElement($endroit)) {
            // set the owning side to null (unless already changed)
            if ($endroit->getCity() === $this) {
                $endroit->setCity(null);
            }
        }

        return $this;
    }
}
