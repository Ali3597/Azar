<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    
     
    #[Route("/login", name:"login")]
    public function login(): void
    {
    }
   
    #[Route("/logout", name:"logout")]
    public function logout(): void
    {
    }
}
