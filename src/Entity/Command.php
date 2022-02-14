<?php

namespace App\Entity;

use App\Repository\CommandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandRepository::class)
 */
class Command
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $treated;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity=ComandProducts::class, mappedBy="commands", cascade={"persist", "remove"})
     */
    private $comandProducts;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->comandProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTreated(): ?bool
    {
        return $this->treated;
    }

    public function setTreated(bool $treated): self
    {
        $this->treated = $treated;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection|ComandProducts[]
     */
    public function getComandProducts(): Collection
    {
        return $this->comandProducts;
    }

    public function addComandProduct(ComandProducts $comandProduct): self
    {
        if (!$this->comandProducts->contains($comandProduct)) {
            $this->comandProducts[] = $comandProduct;
            $comandProduct->setCommands($this);
        }

        return $this;
    }

    public function removeComandProduct(ComandProducts $comandProduct): self
    {
        if ($this->comandProducts->removeElement($comandProduct)) {
            // set the owning side to null (unless already changed)
            if ($comandProduct->getCommands() === $this) {
                $comandProduct->setCommands(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
