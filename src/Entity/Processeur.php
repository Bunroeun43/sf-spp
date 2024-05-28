<?php

namespace App\Entity;

use App\Repository\ProcesseurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProcesseurRepository::class)]
class Processeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'processeurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;

    #[ORM\ManyToOne(inversedBy: 'processeurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Socket $socket = null;

    #[ORM\ManyToOne(inversedBy: 'processeurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeMemoire $typememoire = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\Column]
    private ?int $coeur = null;

    #[ORM\Column]
    private ?float $cache = null;

    #[ORM\Column]
    private ?float $frequence = null;

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

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getCoeur(): ?int
    {
        return $this->coeur;
    }

    public function setCoeur(int $coeur): self
    {
        $this->coeur = $coeur;

        return $this;
    }

    public function getCache(): ?float
    {
        return $this->cache;
    }

    public function setCache(float $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    public function getFrequence(): ?float
    {
        return $this->frequence;
    }

    public function setFrequence(float $frequence): self
    {
        $this->frequence = $frequence;

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
