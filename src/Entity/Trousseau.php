<?php

namespace App\Entity;

use App\Repository\TrousseauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrousseauRepository::class)]
class Trousseau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, Katana>
     */
    #[ORM\OneToMany(targetEntity: Katana::class, mappedBy: 'trousseau', orphanRemoval: true)]
    private Collection $katanas;

    public function __construct()
    {
        $this->katanas = new ArrayCollection();
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

    /**
     * @return Collection<int, Katana>
     */
    public function getKatanas(): Collection
    {
        return $this->katanas;
    }

    public function addKatana(Katana $katana): static
    {
        if (!$this->katanas->contains($katana)) {
            $this->katanas->add($katana);
            $katana->setTrousseau($this);
        }

        return $this;
    }

    public function removeKatana(Katana $katana): static
    {
        if ($this->katanas->removeElement($katana)) {
            // set the owning side to null (unless already changed)
            if ($katana->getTrousseau() === $this) {
                $katana->setTrousseau(null);
            }
        }

        return $this;
    }
}
