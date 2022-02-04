<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use  App\Entity\ViewCounter;


/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
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
class Produit  implements ViewCountable
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
    #[Assert\Length(max: 255, maxMessage: 'Le nom de votre categorie est trop long')]
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ViewCounter::class, mappedBy="produit")
     */
    protected $viewCounters;

    /**
     * @ORM\Column(name="views", type="integer", nullable=true)
     */
    protected $views = 0;


    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\NotBlank(message: 'Veuillez renseigner un stock')]
    #[Assert\PositiveOrZero(message: 'Veuillez renseigner un stock egal a 0 ou positif')]
    #[Assert\Type(
        type: 'integer',
        message: 'Vous devez rentrez un entier',
    )]
    private $stock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\NotBlank(message: 'Veuillez renseigner une unite')]
    #[Assert\Length(max: 255, maxMessage: 'Le nom de votre unite est trop long')]
    private $unite;

    /**
     * @ORM\Column(type="boolean")
     */
    private $afficher;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Assert\NotBlank(message: 'Veuillez renseigner une categorie')]
    private $category;


    private $categoryParent;


    /**
     * @Assert\All({
     *     @Assert\Image(mimeTypes={"image/jpeg", "image/png", "image/gif", "image/jpg"})
     * })
     */
    private $pictureFiles;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="produit",orphanRemoval=true,cascade={"persist", "remove"})
     */
    private $pictures;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class,  inversedBy="produits")
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\NotBlank(message: 'Veuillez rajoutez un slug')]
    #[Assert\Regex(pattern: '/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: "Le slug n'a pas le bon format")]
    private $slug;




    private $basketNumber;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="wants")
     */
    private $usersWanter;

    /**
     * @ORM\OneToOne(targetEntity=Advice::class, cascade={"persist", "remove"})
     */
    private $advices;

    /**
     * @ORM\OneToOne(targetEntity=Description::class, cascade={"persist", "remove"})
     */
    private $descriptionList;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->usersWanter = new ArrayCollection();
        $this->viewCounters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }



    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(?string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getAfficher(): ?bool
    {
        return $this->afficher;
    }

    public function setAfficher(?bool $afficher): self
    {
        $this->afficher = $afficher;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
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
            $picture->setProduit($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getProduit() === $this) {
                $picture->setProduit(null);
            }
        }

        return $this;
    }


    public function getPictureFiles()
    {
        return $this->pictureFiles;
    }


    public function setPictureFiles($pictureFiles)
    {
        foreach ($pictureFiles as $pictureFile) {
            $picture = new Picture();
            $picture->setImageFile($pictureFile);
            $this->addPicture($picture);
        }
        $this->pictureFiles = $pictureFiles;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }



    /**
     * Get the value of categoryParent
     */
    public function getCategoryParent()
    {
        return $this->categoryParent;
    }

    /**
     * Set the value of categoryParent
     *
     * @return  self
     */
    public function setCategoryParent($categoryParent)
    {
        $this->categoryParent = $categoryParent;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of basketNumber
     */
    public function getBasketNumber()
    {
        return $this->basketNumber;
    }

    /**
     * Set the value of basketNumber
     *
     * @return  self
     */
    public function setBasketNumber($basketNumber)
    {
        $this->basketNumber = $basketNumber;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersWanter(): Collection
    {
        return $this->usersWanter;
    }

    public function addUsersWanter(User $usersWanter): self
    {
        if (!$this->usersWanter->contains($usersWanter)) {
            $this->usersWanter[] = $usersWanter;
            $usersWanter->addWant($this);
        }

        return $this;
    }

    public function removeUsersWanter(User $usersWanter): self
    {
        if ($this->usersWanter->removeElement($usersWanter)) {
            $usersWanter->removeWant($this);
        }

        return $this;
    }

    public function getAdvices(): ?Advice
    {
        return $this->advices;
    }

    public function setAdvices(?Advice $advices): self
    {
        $this->advices = $advices;

        return $this;
    }

    public function getDescriptionList(): ?Description
    {
        return $this->descriptionList;
    }

    public function setDescriptionList(?Description $descriptionList): self
    {
        $this->descriptionList = $descriptionList;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }
    /**
     * Sets $views
     *
     * @param integer $views
     *
     * @return $this
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Gets $views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Get $viewCounters
     *
     * @return Collection
     */
    public function getViewCounters()
    {
        return $this->viewCounters;
    }

    /**
     * Add $viewCounter
     *
     * @param ViewCounter $viewCounter
     *
     * @return $this
     */
    public function addViewCounter(ViewCounter $viewCounter)
    {
        $this->viewCounters[] = $viewCounter;

        return $this;
    }

    /**
     * Remove $viewCounter
     *
     * @param ViewCounter $viewCounter
     */
    public function removeViewCounter(ViewCounter $viewCounter)
    {
        $this->viewCounters->removeElement($viewCounter);
    }
}
