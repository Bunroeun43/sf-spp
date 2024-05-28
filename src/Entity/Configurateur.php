<?php

namespace App\Entity;

use App\Repository\ConfigurateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigurateurRepository::class)]
class Configurateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarteMere $cartemere = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Processeur $processeur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Memoire $typememoire = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Boitier $boitier = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?DisqueM2 $disquem2 = null;

    #[ORM\ManyToOne]
    private ?DisqueSsd $disquessd = null;

    #[ORM\ManyToOne]
    private ?DisqueDur $disquedur = null;

    #[ORM\ManyToOne(inversedBy: 'configurateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarteGraphique $cartegraphique = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Alimentation $alimentation = null;

    #[ORM\ManyToOne(inversedBy: 'configurateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    #[ORM\JoinColumn(nullable: false)]
    private ?int $quantiteDisqueDur = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneCommande::class, orphanRemoval: true)]
    private Collection $ligneCommandes;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'configurateurcg2')]
    private ?CarteGraphique $carteGraphique2 = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCartemere(): ?CarteMere
    {
        return $this->cartemere;
    }

    public function setCartemere(?CarteMere $cartemere): self
    {
        $this->cartemere = $cartemere;

        return $this;
    }

    public function getProcesseur(): ?Processeur
    {
        return $this->processeur;
    }

    public function setProcesseur(?Processeur $processeur): self
    {
        $this->processeur = $processeur;

        return $this;
    }

    public function getTypememoire(): ?Memoire
    {
        return $this->typememoire;
    }

    public function setTypememoire(?Memoire $typememoire): self
    {
        $this->typememoire = $typememoire;

        return $this;
    }

    public function getBoitier(): ?Boitier
    {
        return $this->boitier;
    }

    public function setBoitier(?Boitier $boitier): self
    {
        $this->boitier = $boitier;

        return $this;
    }

    public function getDisquem2(): ?DisqueM2
    {
        return $this->disquem2;
    }

    public function setDisquem2(?DisqueM2 $disquem2): self
    {
        $this->disquem2 = $disquem2;

        return $this;
    }

    public function getDisquessd(): ?DisqueSsd
    {
        return $this->disquessd;
    }

    public function setDisquessd(?DisqueSsd $disquessd): self
    {
        $this->disquessd = $disquessd;

        return $this;
    }

    public function getDisquedur(): ?DisqueDur
    {
        return $this->disquedur;
    }

    public function setDisquedur(?DisqueDur $disquedur): self
    {
        $this->disquedur = $disquedur;

        return $this;
    }

    public function getCartegraphique(): ?CarteGraphique
    {
        return $this->cartegraphique;
    }

    public function setCartegraphique(?CarteGraphique $cartegraphique): self
    {
        $this->cartegraphique = $cartegraphique;

        return $this;
    }

    public function getAlimentation(): ?Alimentation
    {
        return $this->alimentation;
    }

    public function setAlimentation(?Alimentation $alimentation): self
    {
        $this->alimentation = $alimentation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getQuantiteDisqueDur(): ?int
    {
        return $this->quantiteDisqueDur;
    }

    public function setQuantiteDisqueDur(int $quantiteDisqueDur): self
    {
        $this->quantiteDisqueDur = $quantiteDisqueDur;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->add($ligneCommande);
            $ligneCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduit() === $this) {
                $ligneCommande->setProduit(null);
            }
        }

        return $this;
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

    public function getCarteGraphique2(): ?CarteGraphique
    {
        return $this->carteGraphique2;
    }

    public function setCarteGraphique2(?CarteGraphique $carteGraphique2): self
    {
        $this->carteGraphique2 = $carteGraphique2;

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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

}
