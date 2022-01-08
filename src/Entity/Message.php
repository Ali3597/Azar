<?php

namespace App\Entity;

use App\Repository\MessageRepository;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{

    #[Assert\NotBlank(message: 'Veuillez renseigner un Nom')]
    #[Assert\Length(min: 2, minMessage: 'Veuillez détailler votre nom', max: 100, maxMessage: 'Le nom est trop long ')]
    private $name;


    #[Assert\Email(message: 'Veuillez rentrer un email valide.')]
    #[Assert\NotBlank(message: 'Veuillez renseigner votre email.')]
    private $email;


    #[Assert\Length(min: 2, minMessage: 'Veuillez détailler votre sujet', max: 100, maxMessage: 'Le sujet est trop long ')]
    private $subject;


    #[Assert\Length(min: 20, minMessage: 'Veuillez détailler votre message')]
    private $content;




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
}
