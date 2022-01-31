<?php

namespace App\Entity;

use App\Repository\AdviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdviceRepository::class)
 */
class Advice
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
    #[Assert\Length(min: 40, minMessage: 'Veuillez détailler votre conseil')]
    private $content;

    /**
     * @ORM\OneToMany(targetEntity=ListProduct::class, mappedBy="advice",cascade={"persist", "remove"})
     */
    private $itemAdviceList;

    public function __construct()
    {
        $this->itemAdviceList = new ArrayCollection();
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
    public function getItemAdviceList(): Collection
    {
        return $this->itemAdviceList;
    }

    public function addItemAdviceList(ListProduct $itemAdviceList): self
    {
        if (!$this->itemAdviceList->contains($itemAdviceList)) {
            $this->itemAdviceList[] = $itemAdviceList;
            $itemAdviceList->setAdvice($this);
        }

        return $this;
    }

    public function removeItemAdviceList(ListProduct $itemAdviceList): self
    {
        if ($this->itemAdviceList->removeElement($itemAdviceList)) {
            // set the owning side to null (unless already changed)
            if ($itemAdviceList->getAdvice() === $this) {
                $itemAdviceList->setAdvice(null);
            }
        }

        return $this;
    }
}
