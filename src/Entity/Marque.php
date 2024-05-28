<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'marques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pays $pays = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: Socket::class)]
    private Collection $sockets;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: Processeur::class)]
    private Collection $processeurs;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: CarteMere::class)]
    private Collection $carteMeres;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: Memoire::class)]
    private Collection $memoires;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: DisqueSsd::class)]
    private Collection $disqueSsds;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: DisqueDur::class)]
    private Collection $disqueDurs;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: Alimentation::class)]
    private Collection $alimentations;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: Boitier::class)]
    private Collection $boitiers;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: CarteGraphique::class)]
    private Collection $carteGraphiques;

    public function __construct()
    {
        $this->sockets = new ArrayCollection();
        $this->processeurs = new ArrayCollection();
        $this->carteMeres = new ArrayCollection();
        $this->memoires = new ArrayCollection();
        $this->disqueSsds = new ArrayCollection();
        $this->disqueDurs = new ArrayCollection();
        $this->alimentations = new ArrayCollection();
        $this->boitiers = new ArrayCollection();
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

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

    /**
     * @return Collection<int, Socket>
     */
    public function getSockets(): Collection
    {
        return $this->sockets;
    }

    public function addSocket(Socket $socket): self
    {
        if (!$this->sockets->contains($socket)) {
            $this->sockets->add($socket);
            $socket->setMarque($this);
        }

        return $this;
    }

    public function removeSocket(Socket $socket): self
    {
        if ($this->sockets->removeElement($socket)) {
            // set the owning side to null (unless already changed)
            if ($socket->getMarque() === $this) {
                $socket->setMarque(null);
            }
        }

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
            $processeur->setMarque($this);
        }

        return $this;
    }

    public function removeProcesseur(Processeur $processeur): self
    {
        if ($this->processeurs->removeElement($processeur)) {
            // set the owning side to null (unless already changed)
            if ($processeur->getMarque() === $this) {
                $processeur->setMarque(null);
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
            $carteMere->setMarque($this);
        }

        return $this;
    }

    public function removeCarteMere(CarteMere $carteMere): self
    {
        if ($this->carteMeres->removeElement($carteMere)) {
            // set the owning side to null (unless already changed)
            if ($carteMere->getMarque() === $this) {
                $carteMere->setMarque(null);
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
            $memoire->setMarque($this);
        }

        return $this;
    }

    public function removeMemoire(Memoire $memoire): self
    {
        if ($this->memoires->removeElement($memoire)) {
            // set the owning side to null (unless already changed)
            if ($memoire->getMarque() === $this) {
                $memoire->setMarque(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DisqueSsd>
     */
    public function getDisqueSsds(): Collection
    {
        return $this->disqueSsds;
    }

    public function addDisqueSsd(DisqueSsd $disqueSsd): self
    {
        if (!$this->disqueSsds->contains($disqueSsd)) {
            $this->disqueSsds->add($disqueSsd);
            $disqueSsd->setMarque($this);
        }

        return $this;
    }

    public function removeDisqueSsd(DisqueSsd $disqueSsd): self
    {
        if ($this->disqueSsds->removeElement($disqueSsd)) {
            // set the owning side to null (unless already changed)
            if ($disqueSsd->getMarque() === $this) {
                $disqueSsd->setMarque(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DisqueDur>
     */
    public function getDisqueDurs(): Collection
    {
        return $this->disqueDurs;
    }

    public function addDisqueDur(DisqueDur $disqueDur): self
    {
        if (!$this->disqueDurs->contains($disqueDur)) {
            $this->disqueDurs->add($disqueDur);
            $disqueDur->setMarque($this);
        }

        return $this;
    }

    public function removeDisqueDur(DisqueDur $disqueDur): self
    {
        if ($this->disqueDurs->removeElement($disqueDur)) {
            // set the owning side to null (unless already changed)
            if ($disqueDur->getMarque() === $this) {
                $disqueDur->setMarque(null);
            }
        }

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
            $alimentation->setMarque($this);
        }

        return $this;
    }

    public function removeAlimentation(Alimentation $alimentation): self
    {
        if ($this->alimentations->removeElement($alimentation)) {
            // set the owning side to null (unless already changed)
            if ($alimentation->getMarque() === $this) {
                $alimentation->setMarque(null);
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
            $boitier->setMarque($this);
        }

        return $this;
    }

    public function removeBoitier(Boitier $boitier): self
    {
        if ($this->boitiers->removeElement($boitier)) {
            // set the owning side to null (unless already changed)
            if ($boitier->getMarque() === $this) {
                $boitier->setMarque(null);
            }
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
            $carteGraphique->setMarque($this);
        }

        return $this;
    }

    public function removeCarteGraphique(CarteGraphique $carteGraphique): self
    {
        if ($this->carteGraphiques->removeElement($carteGraphique)) {
            // set the owning side to null (unless already changed)
            if ($carteGraphique->getMarque() === $this) {
                $carteGraphique->setMarque(null);
            }
        }

        return $this;
    }
}
