<?php

namespace App\Entity;

use App\Repository\FormatAlimentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormatAlimentationRepository::class)]
class FormatAlimentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'format', targetEntity: Alimentation::class)]
    private Collection $alimentations;

    #[ORM\OneToMany(mappedBy: 'formatalimentation', targetEntity: Boitier::class)]
    private Collection $boitiers;

    public function __construct()
    {
        $this->alimentations = new ArrayCollection();
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
     * @return Collection<int, Alimentation>
     */
    public function getAlimentations(): Collection
    {
        return $this->alimentations;
    }

    public function addAlimentation(Alimentation $alimentation): self
    {
        if (!$this->alimentations->contains($alimentation)) {
            $this->alimentations->add($alimentation);
            $alimentation->setFormat($this);
        }

        return $this;
    }

    public function removeAlimentation(Alimentation $alimentation): self
    {
        if ($this->alimentations->removeElement($alimentation)) {
            // set the owning side to null (unless already changed)
            if ($alimentation->getFormat() === $this) {
                $alimentation->setFormat(null);
            }
        }

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
            $boitier->setFormatalimentation($this);
        }

        return $this;
    }

    public function removeBoitier(Boitier $boitier): self
    {
        if ($this->boitiers->removeElement($boitier)) {
            // set the owning side to null (unless already changed)
            if ($boitier->getFormatalimentation() === $this) {
                $boitier->setFormatalimentation(null);
            }
        }

        return $this;
    }
}
