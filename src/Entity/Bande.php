<?php

namespace App\Entity;

use App\Repository\BandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BandeRepository::class)
 */
class Bande
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
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $slideToScroll;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $slideVisible;





    /**
     * @ORM\OneToOne(targetEntity=BandePromo::class, mappedBy="bande", cascade={"persist", "remove"})
     */
    private $bandePromo;

    /**
     * @ORM\OneToOne(targetEntity=BandeProduct::class, mappedBy="bande", cascade={"persist", "remove"})
     */
    private $bandeProduct;



    /**
     * @ORM\OneToOne(targetEntity=BandeCategoryTitle::class, mappedBy="bande", cascade={"persist", "remove"})
     */
    private $bandeCategoryTitle;

    /**
     * @ORM\OneToOne(targetEntity=BandeCategory::class, mappedBy="bande", cascade={"persist", "remove"})
     */
    private $bandeCategory;

    /**
     * @ORM\OneToOne(targetEntity=BandeArticle::class, mappedBy="bande", cascade={"persist", "remove"})
     */
    private $bandeArticle;

    /**
     * @ORM\OneToOne(targetEntity=BandeMarque::class, mappedBy="bande", cascade={"persist", "remove"})
     */
    private $bandeMarque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subtitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;


 



    public function __construct()
    {
        $this->bandePromos = new ArrayCollection();
        $this->bandeCAtegoryTitles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getSlideToScroll(): ?int
    {
        return $this->slideToScroll;
    }

    public function setSlideToScroll(?int $slideToScroll): self
    {
        $this->slideToScroll = $slideToScroll;

        return $this;
    }

    public function getSlideVisible(): ?int
    {
        return $this->slideVisible;
    }

    public function setSlideVisible(?int $slideVisible): self
    {
        $this->slideVisible = $slideVisible;

        return $this;
    }


    public function getBandePromo(): ?BandePromo
    {
        return $this->bandePromo;
    }

    public function setBandePromo(BandePromo $bandePromo): self
    {
        // set the owning side of the relation if necessary
        if ($bandePromo->getBande() !== $this) {
            $bandePromo->setBande($this);
        }

        $this->bandePromo = $bandePromo;

        return $this;
    }

    public function getBandeProduct(): ?BandeProduct
    {
        return $this->bandeProduct;
    }

    public function setBandeProduct(BandeProduct $bandeProduct): self
    {
        // set the owning side of the relation if necessary
        if ($bandeProduct->getBande() !== $this) {
            $bandeProduct->setBande($this);
        }

        $this->bandeProduct = $bandeProduct;

        return $this;
    }


    public function getBandeCategoryTitle(): ?BandeCategoryTitle
    {
        return $this->bandeCategoryTitle;
    }

    public function setBandeCategoryTitle(BandeCategoryTitle $bandeCategoryTitle): self
    {
        // set the owning side of the relation if necessary
        if ($bandeCategoryTitle->getBande() !== $this) {
            $bandeCategoryTitle->setBande($this);
        }

        $this->bandeCategoryTitle = $bandeCategoryTitle;

        return $this;
    }

    public function getBandeCategory(): ?BandeCategory
    {
        return $this->bandeCategory;
    }

    public function setBandeCategory(BandeCategory $bandeCategory): self
    {
        // set the owning side of the relation if necessary
        if ($bandeCategory->getBande() !== $this) {
            $bandeCategory->setBande($this);
        }

        $this->bandeCategory = $bandeCategory;

        return $this;
    }

    public function getBandeArticle(): ?BandeArticle
    {
        return $this->bandeArticle;
    }

    public function setBandeArticle(BandeArticle $bandeArticle): self
    {
        // set the owning side of the relation if necessary
        if ($bandeArticle->getBande() !== $this) {
            $bandeArticle->setBande($this);
        }

        $this->bandeArticle = $bandeArticle;

        return $this;
    }

    public function getbandeMarque(): ?BandeMarque
    {
        return $this->bandeMarque;
    }

    public function setbandeMarque(BandeMarque $bandeMarque): self
    {
        // set the owning side of the relation if necessary
        if ($bandeMarque->getBande() !== $this) {
            $bandeMarque->setBande($this);
        }

        $this->bandeMarque = $bandeMarque;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

   
}
