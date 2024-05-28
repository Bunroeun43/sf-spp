<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaysRepository::class)]
class Pays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $photo = null;

    #[ORM\OneToMany(mappedBy: 'pays', targetEntity: Marque::class)]
    private Collection $marques;

    public function __construct()
    {
        $this->marques = new ArrayCollection();
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection<int, Marque>
     */
    public function getMarques(): Collection
    {
        return $this->marques;
    }

    public function addMarque(Marque $marque): self
    {
        if (!$this->marques->contains($marque)) {
            $this->marques->add($marque);
            $marque->setPays($this);
        }

        return $this;
    }

    public function removeMarque(Marque $marque): self
    {
        if ($this->marques->removeElement($marque)) {
            // set the owning side to null (unless already changed)
            if ($marque->getPays() === $this) {
                $marque->setPays(null);
            }
        }

        return $this;
    }
}
