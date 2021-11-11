<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\BandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{

   
    private $em;
   

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'home')]
    public function index(BandeRepository $bandeRepo): Response
    {
        

        $bandes= $bandeRepo->findAll();
    
        return $this->render('home/index.html.twig', [
            'bandes'=>$bandes,
        ]);
    }
}
