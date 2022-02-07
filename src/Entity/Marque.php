<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MarqueRepository::class)
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
class Marque
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;




    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    #[Assert\NotBlank(message: 'Veuillez renseigner un Nom')]

    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Assert\Length(min: 40, minMessage: 'Veuillez détailler votre description')]
    private $description;



    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="marque")
     */
    private $produits;


    #[Assert\Image(mimeTypes: ["image/jpeg", "image/png", "image/gif", "image/jpg"])]

    private $pictureFile;
    /**
     * @ORM\OneToOne(targetEntity=Picture::class, cascade={"persist", "remove"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, unique=true ,nullable=false)
     */
    #[Assert\NotBlank(message: 'Veuillez rajoutez un slug')]
    #[Assert\Regex(pattern: '/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: "Le slug n'a pas le bon format")]
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=BandeMarque::class, mappedBy="marques")
     */
    private $bandes;
    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->bandes = new ArrayCollection();
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
            $produit->setMarque($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getMarque() === $this) {
                $produit->setMarque(null);
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

    /**
     * @return Collection|BandeMarque[]
     */
    public function getBandes(): Collection
    {
        return $this->bandes;
    }

    public function addBande(BandeMarque $bandeMarque): self
    {
        if (!$this->bandes->contains($bandeMarque)) {
            $this->bandes = $bandeMarque;
            $bandeMarque->addMarque($this);
        }

        return $this;
    }

    public function removeBande(BandeMarque $bandeMarque): self
    {
        if ($this->bandes->removeElement($bandeMarque)) {
            $bandeMarque->removeMarque($this);
        }

        return $this;
    }
}
