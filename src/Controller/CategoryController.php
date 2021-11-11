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

class CategoryController extends AbstractController
{

   
    private $em;
   

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/category', name: 'category')]
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
            dd($user);
            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Bienvenue !');
            return $this->redirectToRoute('home');
        }


    
        return $this->render('category/index.html.twig', [
            'formInscription'=>$userForm->createView(),
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}
