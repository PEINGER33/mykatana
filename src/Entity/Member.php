<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Member implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(inversedBy: 'member', cascade: ['persist', 'remove'])]
    private ?Trousseau $trousseau = null;

    /**
     * @var Collection<int, Katanakake>
     */
    #[ORM\OneToMany(targetEntity: Katanakake::class, mappedBy: 'createur', orphanRemoval: true)]
    private Collection $katanakakes;

    public function __construct()
    {
        $this->katanakakes = new ArrayCollection();
    }
    
    public function __toString(): string
    {
        return $this->email ?? 'Member:'.$this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
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
            $katanakake->setCreateur($this);
        }

        return $this;
    }

    public function removeKatanakake(Katanakake $katanakake): static
    {
        if ($this->katanakakes->removeElement($katanakake)) {
            // set the owning side to null (unless already changed)
            if ($katanakake->getCreateur() === $this) {
                $katanakake->setCreateur(null);
            }
        }

        return $this;
    }
}
