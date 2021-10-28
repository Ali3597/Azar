<?php

namespace App\Entity;

use App\Repository\DesignRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DesignRepository::class)
 */
class Design
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PrimaryColor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sencondaryColor;

    /**
     * @ORM\OneToOne(targetEntity=Picture::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $logo;

    /**
     * @ORM\OneToMany(targetEntity=Bande::class, mappedBy="design", orphanRemoval=true)
     */
    private $bandes;

    public function __construct()
    {
        $this->bandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrimaryColor(): ?string
    {
        return $this->PrimaryColor;
    }

    public function setPrimaryColor(string $PrimaryColor): self
    {
        $this->PrimaryColor = $PrimaryColor;

        return $this;
    }

    public function getSencondaryColor(): ?string
    {
        return $this->sencondaryColor;
    }

    public function setSencondaryColor(string $sencondaryColor): self
    {
        $this->sencondaryColor = $sencondaryColor;

        return $this;
    }

    public function getLogo(): ?Picture
    {
        return $this->logo;
    }

    public function setLogo(Picture $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection|Bande[]
     */
    public function getBandes(): Collection
    {
        return $this->bandes;
    }

    public function addBande(Bande $bande): self
    {
        if (!$this->bandes->contains($bande)) {
            $this->bandes[] = $bande;
            $bande->setDesign($this);
        }

        return $this;
    }

    public function removeBande(Bande $bande): self
    {
        if ($this->bandes->removeElement($bande)) {
            // set the owning side to null (unless already changed)
            if ($bande->getDesign() === $this) {
                $bande->setDesign(null);
            }
        }

        return $this;
    }
}
