<?php

namespace App\Entity;

use App\Repository\PromoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 */
class Promo
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
    #[Assert\Length(min: 10, minMessage: 'Veuillez détailler votre nom', max: 255, maxMessage: 'Le nom de votre promo est trop long')]
    private $name;

    #[Assert\Image(mimeTypes:["image/jpeg", "image/png", "image/gif", "image/jpg"])]
    private $pictureFile;
    /**
     * @ORM\OneToOne(targetEntity=Picture::class, cascade={"persist", "remove"})
     */
    /**
     * @ORM\OneToOne(targetEntity=Picture::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $picture;

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

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(Picture $picture): self
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
}
