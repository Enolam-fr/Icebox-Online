<?php

namespace App\Entity;

use App\Repository\FrigoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FrigoRepository::class)]
class Frigo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'id_frigo')]
    private Collection $id_utilisateur;

    public function __construct()
    {
        $this->id_utilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getIdUtilisateur(): Collection
    {
        return $this->id_utilisateur;
    }

    public function addIdUtilisateur(Utilisateur $idUtilisateur): static
    {
        if (!$this->id_utilisateur->contains($idUtilisateur)) {
            $this->id_utilisateur->add($idUtilisateur);
        }

        return $this;
    }

    public function removeIdUtilisateur(Utilisateur $idUtilisateur): static
    {
        $this->id_utilisateur->removeElement($idUtilisateur);

        return $this;
    }
}
