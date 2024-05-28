<?php

namespace App\Entity;

use App\Repository\DisqueM2Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisqueM2Repository::class)]
class DisqueM2
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $modele = null;

    #[ORM\Column]
    private ?int $capacite = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\OneToMany(mappedBy: 'disqueM2', targetEntity: CarteMere::class)]
    private Collection $carteMeres;

    public function __construct()
    {
        $this->carteMeres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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
            $carteMere->setDisqueM2($this);
        }

        return $this;
    }

    public function removeCarteMere(CarteMere $carteMere): self
    {
        if ($this->carteMeres->removeElement($carteMere)) {
            // set the owning side to null (unless already changed)
            if ($carteMere->getDisqueM2() === $this) {
                $carteMere->setDisqueM2(null);
            }
        }

        return $this;
    }
}
