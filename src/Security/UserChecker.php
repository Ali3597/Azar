<?php

namespace App\Security;

use App\Entity\User as AppUser;
use App\Repository\ResetPasswordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    private $flashbag;


    function __construct(FlashBagInterface $flashbag)
    {
        $this->flashbag = $flashbag;
    }
    public function checkPreAuth(UserInterface $user): void
    {
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user->getIsVerified()) {
            $this->flashbag->add('error', 'Votre compte n\'est pas encore validé veuillez verifié votre boite mail un lien de validation vous a été envoye');
            throw new AccountExpiredException('...');
        }
        elseif($user->getDeleted()){
            $this->flashbag->add('error', 'Vous avez supprimé votre compte de notre plateforme, vous ne pouvez plus vous connectez');
            throw new AccountExpiredException('...');
            
        }
    }
}
