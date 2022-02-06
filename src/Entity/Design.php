<?php

namespace App\Entity;

use App\Repository\DesignRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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


    #[Assert\Image(mimeTypes: ["image/jpeg", "image/png", "image/gif", "image/jpg"])]

    private $pictureFile;

    /**
     * @ORM\OneToOne(targetEntity=Picture::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $headerTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $headerSubTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bandeTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bandeLeft;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bandeCenter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bandeRight;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bandeTitleLeft;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bandeTitleCenter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bandeTitleRight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $colorBande;

    /**
     * @ORM\Column(type="integer")
     */
    private $views;



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

    public function getHeaderTitle(): ?string
    {
        return $this->headerTitle;
    }

    public function setHeaderTitle(string $headerTitle): self
    {
        $this->headerTitle = $headerTitle;

        return $this;
    }

    public function getHeaderSubTitle(): ?string
    {
        return $this->headerSubTitle;
    }

    public function setHeaderSubTitle(string $headerSubTitle): self
    {
        $this->headerSubTitle = $headerSubTitle;

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
            $this->logo = $picture;
        }
        $this->pictureFile = $pictureFile;

        return $this;
    }

    public function getBandeTitle(): ?string
    {
        return $this->bandeTitle;
    }

    public function setBandeTitle(string $bandeTitle): self
    {
        $this->bandeTitle = $bandeTitle;

        return $this;
    }

    public function getBandeLeft(): ?string
    {
        return $this->bandeLeft;
    }

    public function setBandeLeft(string $bandeLeft): self
    {
        $this->bandeLeft = $bandeLeft;

        return $this;
    }

    public function getBandeCenter(): ?string
    {
        return $this->bandeCenter;
    }

    public function setBandeCenter(string $bandeCenter): self
    {
        $this->bandeCenter = $bandeCenter;

        return $this;
    }

    public function getBandeRight(): ?string
    {
        return $this->bandeRight;
    }

    public function setBandeRight(string $bandeRight): self
    {
        $this->bandeRight = $bandeRight;

        return $this;
    }

    public function getBandeTitleLeft(): ?string
    {
        return $this->bandeTitleLeft;
    }

    public function setBandeTitleLeft(string $bandeTitleLeft): self
    {
        $this->bandeTitleLeft = $bandeTitleLeft;

        return $this;
    }

    public function getBandeTitleCenter(): ?string
    {
        return $this->bandeTitleCenter;
    }

    public function setBandeTitleCenter(string $bandeTitleCenter): self
    {
        $this->bandeTitleCenter = $bandeTitleCenter;

        return $this;
    }

    public function getBandeTitleRight(): ?string
    {
        return $this->bandeTitleRight;
    }

    public function setBandeTitleRight(string $bandeTitleRight): self
    {
        $this->bandeTitleRight = $bandeTitleRight;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getColorBande(): ?string
    {
        return $this->colorBande;
    }

    public function setColorBande(string $colorBande): self
    {
        $this->colorBande = $colorBande;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }
    public function addOneView(): self
    {
        $this->views = $this->views + 1;

        return $this;
    }
}
