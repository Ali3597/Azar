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

    #[Assert\Image(mimeTypes: ["image/jpeg", "image/png", "image/gif", "image/jpg"])]
    private $pictureFileAboutUs;
    /**
     * @ORM\OneToOne(targetEntity=Picture::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $aboutUsPicture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $aboutUsTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $aboutUsContent;

    #[Assert\Image(mimeTypes: ["image/jpeg", "image/png", "image/gif", "image/jpg"])]
    private $pictureFileMarque;
    /**
     * @ORM\OneToOne(targetEntity=Picture::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $marquePicture;


    #[Assert\Image(mimeTypes: ["image/jpeg", "image/png", "image/gif", "image/jpg"])]
    private $pictureFileIcon;
    /**
     * @ORM\OneToOne(targetEntity=Picture::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Icon;



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
    /**
     * Get the value of pictureFile
     */
    public function getPictureFileAboutUs()
    {
        return $this->pictureFileAboutUs;
    }

    /**
     * Set the value of pictureFileAboutUs
     *
     * @return  self
     */
    public function setPictureFileAboutUs($pictureFileAboutUs)
    {
        if ($pictureFileAboutUs) {
            $picture = new Picture();
            $picture->setImageFile($pictureFileAboutUs);
            $this->aboutUsPicture = $picture;
        }
        $this->pictureFileAboutUs = $pictureFileAboutUs;

        return $this;
    }

    public function getAboutUsPicture(): ?Picture
    {
        return $this->aboutUsPicture;
    }

    public function setAboutUsPicture(Picture $aboutUsPicture): self
    {
        $this->aboutUsPicture = $aboutUsPicture;

        return $this;
    }

    public function getAboutUsTitle(): ?string
    {
        return $this->aboutUsTitle;
    }

    public function setAboutUsTitle(string $aboutUsTitle): self
    {
        $this->aboutUsTitle = $aboutUsTitle;

        return $this;
    }

    public function getAboutUsContent(): ?string
    {
        return $this->aboutUsContent;
    }

    public function setAboutUsContent(string $aboutUsContent): self
    {
        $this->aboutUsContent = $aboutUsContent;

        return $this;
    }

    /**
     * Get the value of pictureFile
     */
    public function getPictureFileMarque()
    {
        return $this->pictureFileMarque;
    }

    /**
     * Set the value of pictureFileAboutUs
     *
     * @return  self
     */
    public function setPictureFileMarque($pictureFileMarque)
    {
        if ($pictureFileMarque) {
            $picture = new Picture();
            $picture->setImageFile($pictureFileMarque);
            $this->marquePicture = $picture;
        }
        $this->pictureFileMarque = $pictureFileMarque;

        return $this;
    }

    public function getMarquePicture(): ?Picture
    {
        return $this->marquePicture;
    }

    public function setMarquePicture(Picture $marquePicture): self
    {
        $this->marquePicture = $marquePicture;

        return $this;
    }

    public function getIcon(): ?Picture
    {
        return $this->Icon;
    }

    public function setIcon(Picture $Icon): self
    {
        $this->Icon = $Icon;

        return $this;
    }


    /**
     * Get the value of pictureFile
     */
    public function getPictureFileIcon()
    {
        return $this->pictureFileIcon;
    }

    /**
     * Set the value of pictureFileAboutUs
     *
     * @return  self
     */
    public function setPictureFileIcon($pictureFileIcon)
    {
        if ($pictureFileIcon) {
            $picture = new Picture();
            $picture->setImageFile($pictureFileIcon);
            $this->Icon = $picture;
        }
        $this->pictureFileIcon = $pictureFileIcon;

        return $this;
    }
}
