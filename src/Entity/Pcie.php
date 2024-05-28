<?php

namespace App\Entity;

use App\Repository\PcieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PcieRepository::class)]
class Pcie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: CarteMere::class, mappedBy: 'pcie1')]
    private Collection $carteMeres;

    #[ORM\OneToMany(mappedBy: 'pcie', targetEntity: CarteGraphique::class)]
    private Collection $carteGraphiques;

    public function __construct()
    {
        $this->carteMeres = new ArrayCollection();
        $this->carteGraphiques = new ArrayCollection();
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
     * @return Collection<int, CarteMere>
     */
    public function getCarteMeres(): Collection
    {
        return $this->carteMeres;
    }

    public function addCarteMere(CarteMere $carteMere): self
    {
        if (!$this->carteMeres->contains($carteMere)) {
            $this->carteMeres->add($carteMere);
            $carteMere->addPcie1($this);
        }

        return $this;
    }

    public function removeCarteMere(CarteMere $carteMere): self
    {
        if ($this->carteMeres->removeElement($carteMere)) {
            $carteMere->removePcie1($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, CarteGraphique>
     */
    public function getCarteGraphiques(): Collection
    {
        return $this->carteGraphiques;
    }

    public function addCarteGraphique(CarteGraphique $carteGraphique): self
    {
        if (!$this->carteGraphiques->contains($carteGraphique)) {
            $this->carteGraphiques->add($carteGraphique);
            $carteGraphique->setPcie($this);
        }

        return $this;
    }

    public function removeCarteGraphique(CarteGraphique $carteGraphique): self
    {
        if ($this->carteGraphiques->removeElement($carteGraphique)) {
            // set the owning side to null (unless already changed)
            if ($carteGraphique->getPcie() === $this) {
                $carteGraphique->setPcie(null);
            }
        }

        return $this;
    }
}
