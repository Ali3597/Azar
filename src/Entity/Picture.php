<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PictureRepository::class)
 * @Vich\Uploadable()
 */
class Picture
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
    private $filename;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="property_image",fileNameProperty="filename")
     */
    #[Assert\Image(mimeTypes: 'jpeg', massage: 'Pour les images veuillez utilisez le format jpeg')]
    private $imageFile;



    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="pictures")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="pictures")
     */
    private $produit;





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }


    public function getImageFile()
    {
        return $this->imageFile;
    }


    public function setImageFile($imageFile)
    {

        $this->imageFile = $imageFile;
        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
