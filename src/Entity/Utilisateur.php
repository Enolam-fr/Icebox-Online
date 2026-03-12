<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 25)]
    private ?string $telephone = null;

    /**
     * @var Collection<int, Frigo>
     */
    #[ORM\ManyToMany(targetEntity: Frigo::class, mappedBy: 'id_utilisateur')]
    private Collection $id_frigo;

    public function __construct()
    {
        $this->id_frigo = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, Frigo>
     */
    public function getIdFrigo(): Collection
    {
        return $this->id_frigo;
    }

    public function addIdFrigo(Frigo $idFrigo): static
    {
        if (!$this->id_frigo->contains($idFrigo)) {
            $this->id_frigo->add($idFrigo);
            $idFrigo->addIdUtilisateur($this);
        }

        return $this;
    }

    public function removeIdFrigo(Frigo $idFrigo): static
    {
        if ($this->id_frigo->removeElement($idFrigo)) {
            $idFrigo->removeIdUtilisateur($this);
        }

        return $this;
    }
}
