<?php

namespace App\Entity;

use App\Repository\FormatDisqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormatDisqueRepository::class)]
class FormatDisque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'format', targetEntity: DisqueDur::class)]
    private Collection $disqueDurs;

    public function __construct()
    {
        $this->disqueDurs = new ArrayCollection();
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
            $disqueDur->setFormat($this);
        }

        return $this;
    }

    public function removeDisqueDur(DisqueDur $disqueDur): self
    {
        if ($this->disqueDurs->removeElement($disqueDur)) {
            // set the owning side to null (unless already changed)
            if ($disqueDur->getFormat() === $this) {
                $disqueDur->setFormat(null);
            }
        }

        return $this;
    }
}
