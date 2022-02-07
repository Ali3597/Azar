<?php

namespace App\Entity;

use App\Repository\BandeProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BandeProductRepository::class)
 */
class BandeProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Bande::class, inversedBy="bandeProduct", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bande;

    /**
     * @ORM\ManyToMany(targetEntity=Produit::class, inversedBy="bandes")
     */
    private $products;


    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * @return Collection|Produit[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Produit $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Produit $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }
}
