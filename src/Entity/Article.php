<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
#[UniqueEntity(
    fields: ['slug'],
    errorPath: 'slug',
    message: 'Ce slug est deja utilisé',
)]
class Article implements ViewCountable

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
    #[Assert\Length(min: 50, minMessage: 'Veuillez détailler votre contenu')]
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\OneToOne(targetEntity=Picture::class, cascade={"persist", "remove"})
     */
    private $picture;

    #[Assert\Image(mimeTypes: ["image/jpeg", "image/png", "image/gif", "image/jpg"])]
    private $pictureFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\NotBlank(message: 'Veuillez rajoutez un slug')]
    #[Assert\Regex(pattern: '/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: "Le slug n'a pas le bon format")]
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=ViewCounter::class, mappedBy="article")
     */
    private $viewCounters;

    /**
     * @ORM\Column(name="views", type="integer", nullable=true)
     */
    private $views = 0;

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
