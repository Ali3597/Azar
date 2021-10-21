<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    #[Assert\NotBlank(message: 'Veuillez renseigner un Nom')]
    #[Assert\Length(min: 10, minMessage: 'Veuillez détailler votre nom', max: 255, maxMessage: 'Le nom de votre categorie est trop long')]
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Assert\Length(min: 40, minMessage: 'Veuillez détailler votre description')]
    private $description;

     /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="category_parent")
     */
    private $categories_childrens;

   /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="categories_childrens")
     */
  
    private $category_parent;

    public function __construct()
    {
        $this->categories_children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategoryParent(): ?self
    {
        return $this->category_parent;
    }

    public function setCategoryParent(?self $category_parent): self
    {
        $this->category_parent = $category_parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(self $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie[] = $categorie;
            $categorie->setCategoryParent($this);
        }

        return $this;
    }

    public function removeCategorie(self $categorie): self
    {
        if ($this->categorie->removeElement($categorie)) {
            // set the owning side to null (unless already changed)
            if ($categorie->getCategoryParent() === $this) {
                $categorie->setCategoryParent(null);
            }
        }

        return $this;
    }
}
