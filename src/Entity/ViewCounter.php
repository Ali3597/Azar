<?php

namespace App\Entity;

use App\Repository\ViewCounterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ViewCounterRepository::class)
 */
class ViewCounter
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
    private $ip;

    /**
     * @ORM\Column(type="datetime")
     */
    private $viewDate;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Design::class)
     */
    private $design;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class)
     */
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getViewDate(): ?\DateTimeInterface
    {
        return $this->viewDate;
    }

    public function setViewDate(\DateTimeInterface $viewDate): self
    {
        $this->viewDate = $viewDate;

        return $this;
    }

    public function getProduct(): ?Produit
    {
        return $this->product;
    }

    public function setProduct(?Produit $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getDesign(): ?Design
    {
        return $this->design;
    }

    public function setDesign(?Design $design): self
    {
        $this->design = $design;

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

    public function setEntity($item): self
    {
        if ($item instanceof Produit) {
            $this->setProduct($item);
        } elseif ($item instanceof Article) {
            $this->setArticle($item);
        } elseif ($item instanceof Design) {
            $this->setDesign($item);
        }
        return $this;
    }
}
