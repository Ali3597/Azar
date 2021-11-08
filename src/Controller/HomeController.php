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
    public function index(Request $request,UserPasswordHasherInterface $passwordHasher,AuthenticationUtils $authenticationUtils,BandeRepository $bandeRepo): Response
    {
        //connexion 
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        //inscription
        $user =  new User();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid())
        {
            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Bienvenue !');
            return $this->redirectToRoute('home');
        }

        $bandes= $bandeRepo->findAll();
    
        return $this->render('home/index.html.twig', [
            'bandes'=>$bandes,
            'formInscription'=>$userForm->createView(),
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}
