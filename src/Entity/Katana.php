<?php

namespace App\Entity;

use App\Repository\KatanaRepository;
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
}
