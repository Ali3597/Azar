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
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="bandePromo")
     */
    private $pictures;

    /**
     * @ORM\OneToOne(targetEntity=Bande::class, inversedBy="bandePromo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bande;

   

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setBandePromo($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getBandePromo() === $this) {
                $picture->setBandePromo(null);
            }
        }

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
