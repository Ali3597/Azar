<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
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
    #[Assert\NotBlank(message: 'Veuillez renseigner un titre')]
    #[Assert\Length(min: 10, minMessage: 'Veuillez détailler votre titre', max: 255, maxMessage: 'Le titre de votre article est trop long')]
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    #[Assert\NotBlank(message: 'Veuillez renseigner un contenu')]
    #[Assert\Length(min: 10, minMessage: 'Veuillez détailler votre contenu')]
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="article",orphanRemoval=true,cascade={"persist"})
     */
    private $pictures;

    /**
     * @Assert\All({
     *     @Assert\Image(mimeTypes="image/jpeg")
     * })
     */
    private $pictureFiles;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

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
            $picture->setArticle($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getArticle() === $this) {
                $picture->setArticle(null);
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
        foreach($pictureFiles as $pictureFile)
        {
            $picture = new Picture();
            $picture->setImageFile($pictureFile);
            $this->addPicture($picture);
        }
        $this->pictureFiles = $pictureFiles;

        return $this;
    }
}
