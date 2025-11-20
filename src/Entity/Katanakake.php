<?php

namespace App\Entity;

use App\Repository\KatanakakeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KatanakakeRepository::class)]
class Katanakake
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $publiee = null;

    /**
     * @var Collection<int, Katana>
     */
    #[ORM\ManyToMany(targetEntity: Katana::class, inversedBy: 'katanakakes')]
    private Collection $katanas;

    #[ORM\ManyToOne(inversedBy: 'katanakakes')]
    #[ORM\JoinColumn(nullable: false)]   # Attention étant donné que la relation a été faite trop tot elle géne le code donc "True" mais sinon "False"
    private ?Member $createur = null;

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

    public function isPubliee(): ?bool
    {
        return $this->publiee;
    }

    public function setPubliee(bool $publiee): static
    {
        $this->publiee = $publiee;

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
        }

        return $this;
    }

    public function removeKatana(Katana $katana): static
    {
        $this->katanas->removeElement($katana);

        return $this;
    }

    public function getCreateur(): ?Member
    {
        return $this->createur;
    }

    public function setCreateur(?Member $createur): static
    {
        $this->createur = $createur;

        return $this;
    }
}
