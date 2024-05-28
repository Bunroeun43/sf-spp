<?php

namespace App\Entity;

use App\Repository\CouleurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouleurRepository::class)]
class Couleur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'couleur', targetEntity: Boitier::class)]
    private Collection $boitiers;

    public function __construct()
    {
        $this->boitiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Boitier>
     */
    public function getBoitiers(): Collection
    {
        return $this->boitiers;
    }

    public function addBoitier(Boitier $boitier): self
    {
        if (!$this->boitiers->contains($boitier)) {
            $this->boitiers->add($boitier);
            $boitier->setCouleur($this);
        }

        return $this;
    }

    public function removeBoitier(Boitier $boitier): self
    {
        if ($this->boitiers->removeElement($boitier)) {
            // set the owning side to null (unless already changed)
            if ($boitier->getCouleur() === $this) {
                $boitier->setCouleur(null);
            }
        }

        return $this;
    }
}
