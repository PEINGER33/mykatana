<?php

namespace App\Entity;

use App\Repository\KatanaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KatanaRepository::class)]
class Katana
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?float $longueur = null;

    #[ORM\ManyToOne(inversedBy: 'katanas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trousseau $trousseau = null;

    /**
     * @var Collection<int, Katanakake>
     */
    #[ORM\ManyToMany(targetEntity: Katanakake::class, mappedBy: 'katanas')]
    private Collection $katanakakes;

    public function __construct()
    {
        $this->katanakakes = new ArrayCollection();
    }
    
    public function __toString(): string
    {
        return $this->description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): static
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getTrousseau(): ?Trousseau
    {
        return $this->trousseau;
    }

    public function setTrousseau(?Trousseau $trousseau): static
    {
        $this->trousseau = $trousseau;

        return $this;
    }

    /**
     * @return Collection<int, Katanakake>
     */
    public function getKatanakakes(): Collection
    {
        return $this->katanakakes;
    }

    public function addKatanakake(Katanakake $katanakake): static
    {
        if (!$this->katanakakes->contains($katanakake)) {
            $this->katanakakes->add($katanakake);
            $katanakake->addKatana($this);
        }

        return $this;
    }

    public function removeKatanakake(Katanakake $katanakake): static
    {
        if ($this->katanakakes->removeElement($katanakake)) {
            $katanakake->removeKatana($this);
        }

        return $this;
    }
}
