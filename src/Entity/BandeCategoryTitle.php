<?php

namespace App\Entity;

use App\Repository\BandeCategoryTitleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BandeCategoryTitleRepository::class)
 */
class BandeCategoryTitle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="bandesTitle")
     */
    private $categories;

    /**
     * @ORM\OneToOne(targetEntity=Bande::class, inversedBy="bandeCategoryTitle", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bande;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

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
