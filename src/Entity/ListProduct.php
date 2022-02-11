<?php

namespace App\Entity;

use App\Repository\ListProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ListProductRepository::class)
 */
class ListProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    #[Assert\NotBlank(message: 'Vous n\'avez rien renseigner ici')]
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Description::class, inversedBy="itemList", cascade={"persist"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Advice::class, inversedBy="itemList")
     */
    private $advice;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?Description
    {
        return $this->description;
    }

    public function setDescription(?Description $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAdvice(): ?Advice
    {
        return $this->advice;
    }

    public function setAdvice(?Advice $advice): self
    {
        $this->advice = $advice;

        return $this;
    }
}
