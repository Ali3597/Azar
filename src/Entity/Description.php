<?php

namespace App\Entity;

use App\Repository\DescriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DescriptionRepository::class)
 */
class Description
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Assert\Length(min: 40, minMessage: 'Veuillez détailler votre description')]
    private $content;

    /**
     * @ORM\OneToMany(targetEntity=ListProduct::class, mappedBy="description", cascade={"persist", "remove"})
     */
    private $itemList;

    public function __construct()
    {
        $this->itemList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection|ListProduct[]
     */
    public function getItemList(): Collection
    {
        return $this->itemList;
    }

    public function addItemList(ListProduct $itemList): self
    {
        if (!$this->itemList->contains($itemList)) {
            $this->itemList[] = $itemList;
            $itemList->setDescription($this);
        }

        return $this;
    }

    public function removeItemList(ListProduct $itemList): self
    {
        if ($this->itemList->removeElement($itemList)) {
            // set the owning side to null (unless already changed)
            if ($itemList->getDescription() === $this) {
                $itemList->setDescription(null);
            }
        }

        return $this;
    }
}
