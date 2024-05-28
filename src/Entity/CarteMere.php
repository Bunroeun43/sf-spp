<?php

namespace App\Entity;

use App\Repository\CarteMereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteMereRepository::class)]
class CarteMere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'carteMeres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\ManyToOne(inversedBy: 'carteMeres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Socket $socket = null;

    #[ORM\ManyToOne(inversedBy: 'carteMeres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeMemoire $typememoire = null;

    #[ORM\Column]
    private ?int $slotmemoire = null;

    #[ORM\Column]
    private ?bool $m2 = null;

    #[ORM\Column]
    private ?int $sata = null;

    #[ORM\Column]
    private ?bool $wifi = null;

    #[ORM\Column]
    private ?bool $bluetooth = null;

    #[ORM\Column]
    private ?int $rj45 = null;

    #[ORM\ManyToOne(inversedBy: 'carteMeres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FormatCarteMere $format = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pcie $pcie1 = null;

    #[ORM\ManyToOne]
    private ?Pcie $pcie2 = null;

    #[ORM\ManyToOne]
    private ?Pcie $pcie3 = null;

    #[ORM\OneToMany(mappedBy: 'cartemere', targetEntity: LigneCommande::class, orphanRemoval: true)]
    private Collection $ligneCommandes;

    #[ORM\ManyToOne(inversedBy: 'carteMeres')]
    private ?DisqueM2 $disqueM2 = null;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
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

    public function getSocket(): ?Socket
    {
        return $this->socket;
    }

    public function setSocket(?Socket $socket): self
    {
        $this->socket = $socket;

        return $this;
    }

    public function getTypememoire(): ?TypeMemoire
    {
        return $this->typememoire;
    }

    public function setTypememoire(?TypeMemoire $typememoire): self
    {
        $this->typememoire = $typememoire;

        return $this;
    }

    public function getSlotmemoire(): ?int
    {
        return $this->slotmemoire;
    }

    public function setSlotmemoire(int $slotmemoire): self
    {
        $this->slotmemoire = $slotmemoire;

        return $this;
    }

    public function isM2(): ?bool
    {
        return $this->m2;
    }

    public function setM2(bool $m2): self
    {
        $this->m2 = $m2;

        return $this;
    }

    public function getSata(): ?int
    {
        return $this->sata;
    }

    public function setSata(int $sata): self
    {
        $this->sata = $sata;

        return $this;
    }

    public function isWifi(): ?bool
    {
        return $this->wifi;
    }

    public function setWifi(bool $wifi): self
    {
        $this->wifi = $wifi;

        return $this;
    }

    public function isBluetooth(): ?bool
    {
        return $this->bluetooth;
    }

    public function setBluetooth(bool $bluetooth): self
    {
        $this->bluetooth = $bluetooth;

        return $this;
    }

    public function getRj45(): ?int
    {
        return $this->rj45;
    }

    public function setRj45(int $rj45): self
    {
        $this->rj45 = $rj45;

        return $this;
    }

    public function getFormat(): ?FormatCarteMere
    {
        return $this->format;
    }

    public function setFormat(?FormatCarteMere $format): self
    {
        $this->format = $format;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPcie1(): ?Pcie
    {
        return $this->pcie1;
    }

    public function setPcie1(?Pcie $pcie1): self
    {
        $this->pcie1 = $pcie1;

        return $this;
    }

    public function getPcie2(): ?Pcie
    {
        return $this->pcie2;
    }

    public function setPcie2(?Pcie $pcie2): self
    {
        $this->pcie2 = $pcie2;

        return $this;
    }

    public function getPcie3(): ?Pcie
    {
        return $this->pcie3;
    }

    public function setPcie3(?Pcie $pcie3): self
    {
        $this->pcie3 = $pcie3;

        return $this;
    }

    public function getDisqueM2(): ?DisqueM2
    {
        return $this->disqueM2;
    }

    public function setDisqueM2(?DisqueM2 $disqueM2): self
    {
        $this->disqueM2 = $disqueM2;

        return $this;
    }

}
