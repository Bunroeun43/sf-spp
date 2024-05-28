<?php

namespace App\Entity;

use App\Repository\MemoireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemoireRepository::class)]
class Memoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'memoires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\ManyToOne(inversedBy: 'memoires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeMemoire $typememoire = null;

    #[ORM\Column]
    private ?int $taille = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?bool $isActive = null;

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

    public function getTypememoire(): ?TypeMemoire
    {
        return $this->typememoire;
    }

    public function setTypememoire(?TypeMemoire $typememoire): self
    {
        $this->typememoire = $typememoire;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): self
    {
        $this->taille = $taille;

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
}
