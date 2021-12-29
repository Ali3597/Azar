<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
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
    #[Assert\Length(min: 2, minMessage: 'Veuillez détailler votre nom', max: 100, maxMessage: 'Le nom est trop long ')]
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\Email(message: 'Veuillez rentrer un email valide.')]
    #[Assert\NotBlank(message: 'Veuillez renseigner votre email.')]
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\Length(min: 2, minMessage: 'Veuillez détailler votre sujet', max: 100, maxMessage: 'Le sujet est trop long ')]
    private $subject;

    /**
     * @ORM\Column(type="text")
     */
    #[Assert\Length(min: 20, minMessage: 'Veuillez détailler votre message')]
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

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
}
