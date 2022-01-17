<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
#[UniqueEntity(
    fields: ['slug'],
    errorPath: 'slug',
    message: 'Ce slug est deja utilisé',
)]
#[UniqueEntity(
    fields: ['name'],
    errorPath: 'name',
    message: 'Ce nom est deja utilisé',
)]
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     */
    #[Assert\NotBlank(message: 'Veuillez renseigner un Nom')]
    #[Assert\Length(max: 255, maxMessage: 'Le nom de votre categorie est trop long')]
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="category_parent" ,orphanRemoval=true)
     */
    private $categories_children;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="categories_childrens")
     */

    private $category_parent;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="category", orphanRemoval=true)
     */
    private $produits;

    /**
     * @ORM\OneToOne(targetEntity=Picture::class, cascade={"persist", "remove"})
     */
    private $picture;

    #[Assert\Image(mimeTypes: ["image/jpeg", "image/png", "image/gif", "image/jpg"])]
    private $pictureFile;

    /**
     * @ORM\Column(type="string", length=255, unique=true ,nullable=false)
     */
    #[Assert\NotBlank(message: 'Veuillez rajoutez un slug')]
    #[Assert\Regex(pattern: '/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: "Le slug n'a pas le bon format")]
    private $slug;

    public function __construct()
    {
        $this->categories_children = new ArrayCollection();
        $this->produits = new ArrayCollection();
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
    public function getCategoriesChildrens(): Collection
    {
        return $this->categories_children;
    }

    public function addCategorie(self $categorie): self
    {
        if (!$this->categories_children->contains($categorie)) {
            $this->categories_children[] = $categorie;
            $categorie->setCategoryParent($this);
        }

        return $this;
    }

    public function removeCategorie(self $categorie): self
    {
        if ($this->categories_children->removeElement($categorie)) {
            // set the owning side to null (unless already changed)
            if ($categorie->getCategoryParent() === $this) {
                $categorie->setCategoryParent(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setCategory($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategory() === $this) {
                $produit->setCategory(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(?Picture $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get the value of pictureFile
     */
    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    /**
     * Set the value of pictureFile
     *
     * @return  self
     */
    public function setPictureFile($pictureFile)
    {
        if ($pictureFile) {
            $picture = new Picture();
            $picture->setImageFile($pictureFile);
            $this->picture = $picture;
        }

        $this->pictureFile = $pictureFile;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
