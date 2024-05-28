<?php

namespace App\Entity;

use App\Repository\BoitierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoitierRepository::class)]
class Boitier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'boitiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\ManyToOne(inversedBy: 'boitiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FormatBoitier $format = null;

    #[ORM\ManyToOne(inversedBy: 'boitiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FormatCarteMere $formatcartemere = null;

    #[ORM\ManyToOne(inversedBy: 'boitiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FormatAlimentation $formatalimentation = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'boitiers')]
    private ?Couleur $couleur = null;

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

    public function getFormat(): ?FormatBoitier
    {
        return $this->format;
    }

    public function setFormat(?FormatBoitier $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getFormatcartemere(): ?FormatCarteMere
    {
        return $this->formatcartemere;
    }

    public function setFormatcartemere(?FormatCarteMere $formatcartemere): self
    {
        $this->formatcartemere = $formatcartemere;

        return $this;
    }

    public function getFormatalimentation(): ?FormatAlimentation
    {
        return $this->formatalimentation;
    }

    public function setFormatalimentation(?FormatAlimentation $formatalimentation): self
    {
        $this->formatalimentation = $formatalimentation;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getCouleur(): ?Couleur
    {
        return $this->couleur;
    }

    public function setCouleur(?Couleur $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

}
