<?php

namespace App\Entity;

use App\Repository\TypeMemoireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeMemoireRepository::class)]
class TypeMemoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'typememoire', targetEntity: Processeur::class)]
    private Collection $processeurs;

    #[ORM\OneToMany(mappedBy: 'typememoire', targetEntity: CarteMere::class)]
    private Collection $carteMeres;

    #[ORM\OneToMany(mappedBy: 'typememoire', targetEntity: Memoire::class)]
    private Collection $memoires;

    public function __construct()
    {
        $this->processeurs = new ArrayCollection();
        $this->carteMeres = new ArrayCollection();
        $this->memoires = new ArrayCollection();
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
     * @return Collection<int, Processeur>
     */
    public function getProcesseurs(): Collection
    {
        return $this->processeurs;
    }

    public function addProcesseur(Processeur $processeur): self
    {
        if (!$this->processeurs->contains($processeur)) {
            $this->processeurs->add($processeur);
            $processeur->setTypememoire($this);
        }

        return $this;
    }

    public function removeProcesseur(Processeur $processeur): self
    {
        if ($this->processeurs->removeElement($processeur)) {
            // set the owning side to null (unless already changed)
            if ($processeur->getTypememoire() === $this) {
                $processeur->setTypememoire(null);
            }
        }

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
            $carteMere->setTypememoire($this);
        }

        return $this;
    }

    public function removeCarteMere(CarteMere $carteMere): self
    {
        if ($this->carteMeres->removeElement($carteMere)) {
            // set the owning side to null (unless already changed)
            if ($carteMere->getTypememoire() === $this) {
                $carteMere->setTypememoire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Memoire>
     */
    public function getMemoires(): Collection
    {
        return $this->memoires;
    }

    public function addMemoire(Memoire $memoire): self
    {
        if (!$this->memoires->contains($memoire)) {
            $this->memoires->add($memoire);
            $memoire->setTypememoire($this);
        }

        return $this;
    }

    public function removeMemoire(Memoire $memoire): self
    {
        if ($this->memoires->removeElement($memoire)) {
            // set the owning side to null (unless already changed)
            if ($memoire->getTypememoire() === $this) {
                $memoire->setTypememoire(null);
            }
        }

        return $this;
    }
}
