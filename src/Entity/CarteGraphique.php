<?php

namespace App\Entity;

use App\Repository\CarteGraphiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteGraphiqueRepository::class)]
class CarteGraphique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'carteGraphiques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\Column]
    private ?int $memoire = null;

    #[ORM\ManyToOne(inversedBy: 'carteGraphiques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pcie $pcie = null;

    #[ORM\Column]
    private ?int $longueur = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'cartegraphique', targetEntity: Configurateur::class)]
    private Collection $configurateurs;

    #[ORM\OneToMany(mappedBy: 'carteGraphique2', targetEntity: Configurateur::class)]
    private Collection $configurateurcg2;

    public function __construct()
    {
        $this->configurateurs = new ArrayCollection();
        $this->configurateurcg2 = new ArrayCollection();
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

    public function getMemoire(): ?int
    {
        return $this->memoire;
    }

    public function setMemoire(int $memoire): self
    {
        $this->memoire = $memoire;

        return $this;
    }

    public function getPcie(): ?Pcie
    {
        return $this->pcie;
    }

    public function setPcie(?Pcie $pcie): self
    {
        $this->pcie = $pcie;

        return $this;
    }

    public function getLongueur(): ?int
    {
        return $this->longueur;
    }

    public function setLongueur(int $longueur): self
    {
        $this->longueur = $longueur;

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
     * @return Collection<int, Configurateur>
     */
    public function getConfigurateurs(): Collection
    {
        return $this->configurateurs;
    }

    public function addConfigurateur(Configurateur $configurateur): self
    {
        if (!$this->configurateurs->contains($configurateur)) {
            $this->configurateurs->add($configurateur);
            $configurateur->setCartegraphique($this);
        }

        return $this;
    }

    public function removeConfigurateur(Configurateur $configurateur): self
    {
        if ($this->configurateurs->removeElement($configurateur)) {
            // set the owning side to null (unless already changed)
            if ($configurateur->getCartegraphique() === $this) {
                $configurateur->setCartegraphique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Configurateur>
     */
    public function getConfigurateurcg2(): Collection
    {
        return $this->configurateurcg2;
    }

    public function addConfigurateurcg2(Configurateur $configurateurcg2): self
    {
        if (!$this->configurateurcg2->contains($configurateurcg2)) {
            $this->configurateurcg2->add($configurateurcg2);
            $configurateurcg2->setCarteGraphique2($this);
        }

        return $this;
    }

    public function removeConfigurateurcg2(Configurateur $configurateurcg2): self
    {
        if ($this->configurateurcg2->removeElement($configurateurcg2)) {
            // set the owning side to null (unless already changed)
            if ($configurateurcg2->getCarteGraphique2() === $this) {
                $configurateurcg2->setCarteGraphique2(null);
            }
        }

        return $this;
    }
}
