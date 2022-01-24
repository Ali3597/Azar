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
}
