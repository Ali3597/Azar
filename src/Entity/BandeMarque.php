<?php

namespace App\Entity;

use App\Repository\BandeMarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BandeMarqueRepository::class)
 */
class BandeMarque
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Marque::class, inversedBy="bandes")
     */
    private $marques;

    /**
     * @ORM\OneToOne(targetEntity=Bande::class, inversedBy="bandeMarque", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bande;



    public function __construct()
    {
        $this->marques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Marque[]
     */
    public function getMarques(): Collection
    {
        return $this->marques;
    }

    public function addMarque(Marque $marque): self
    {
        if (!$this->marques->contains($marque)) {
            $this->marques[] = $marque;
        }

        return $this;
    }

    public function removeMarque(Marque $marque): self
    {
        $this->marques->removeElement($marque);

        return $this;
    }

    public function getBande(): ?Bande
    {
        return $this->bande;
    }

    public function setBande(Bande $bande): self
    {
        $this->bande = $bande;

        return $this;
    }
}
