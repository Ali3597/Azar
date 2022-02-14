<?php

namespace App\Entity;

use App\Repository\ComandProductsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComandProductsRepository::class)
 */
class ComandProducts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class,cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity=Command::class, inversedBy="comandProducts",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commands;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getProducts(): ?Produit
    {
        return $this->products;
    }

    public function setProducts(?Produit $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getCommands(): ?Command
    {
        return $this->commands;
    }

    public function setCommands(?Command $commands): self
    {
        $this->commands = $commands;

        return $this;
    }
}
