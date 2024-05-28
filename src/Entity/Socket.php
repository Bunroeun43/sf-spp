<?php

namespace App\Entity;

use App\Repository\SocketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocketRepository::class)]
class Socket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'sockets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;

    #[ORM\OneToMany(mappedBy: 'socket', targetEntity: Processeur::class)]
    private Collection $processeurs;

    #[ORM\OneToMany(mappedBy: 'socket', targetEntity: CarteMere::class)]
    private Collection $carteMeres;

    public function __construct()
    {
        $this->processeurs = new ArrayCollection();
        $this->carteMeres = new ArrayCollection();
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

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

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
            $processeur->setSocket($this);
        }

        return $this;
    }

    public function removeProcesseur(Processeur $processeur): self
    {
        if ($this->processeurs->removeElement($processeur)) {
            // set the owning side to null (unless already changed)
            if ($processeur->getSocket() === $this) {
                $processeur->setSocket(null);
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
            $carteMere->setSocket($this);
        }

        return $this;
    }

    public function removeCarteMere(CarteMere $carteMere): self
    {
        if ($this->carteMeres->removeElement($carteMere)) {
            // set the owning side to null (unless already changed)
            if ($carteMere->getSocket() === $this) {
                $carteMere->setSocket(null);
            }
        }

        return $this;
    }
}
