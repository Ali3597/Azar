<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Rollerworks\Component\PasswordStrength\Validator\Constraints as RollerworksPassword;

use Symfony\Component\Validator\Constraints as Assert;

class UserPassword
{


    /**
     * @var string The hashed password
     * 
     * @RollerworksPassword\PasswordRequirements(requireLetters=true,minLength=8, requireNumbers=true, requireCaseDiff=true)
     */
    #[Assert\NotBlank(message: 'Veuillez renseigner un mot de passe.')]
    private $password;

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
