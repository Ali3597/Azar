<?php

namespace App\Entity;

use App\Repository\BandePromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BandePromoRepository::class)
 */
class BandePromo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    

    /**
     * @ORM\OneToOne(targetEntity=Bande::class, inversedBy="bandePromo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bande;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class)
     */
    private $promos;

   

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->promos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        $this->promos->removeElement($promo);

        return $this;
    }

   
}
