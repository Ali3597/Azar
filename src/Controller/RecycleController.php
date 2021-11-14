<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\BandeRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Repository\CategoryRepository;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RecycleController extends AbstractController
{

    private $em;
   

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

   
    
    #[Route('/formLogin', name: 'formLogin', methods: [ 'POST'])]
    public function header(Request $request,UserAuthenticatorInterface $authenticator,LoginFormAuthenticator $loginForm,UserPasswordHasherInterface $passwordHasher,AuthenticationUtils $authenticationUtils,CategoryRepository $categoryRepo, MailerInterface $mailer): Response
    {
       
        $categories = $categoryRepo->findAllHighCategories();

        //connexion 
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        //inscription
        $user =  new User();
        $userForm = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('formLogin'),
        ]);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted()){
            if($userForm->isValid())
        {
         
            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Bienvenue !');
            $email = new TemplatedEmail();
            $email->to($user->getEmail())
              ->subject('Bienvenue sur Wonder')
              ->htmlTemplate('@email_templates/welcome.html.twig')
              ->context([
                'username' => $user->getFirstname()
              ]);
            $mailer->send($email);
            return $authenticator->authenticateUser(
                $user,
                $loginForm,
                $request
              );
        }
        else{
            return $this->redirectToRoute('home');
        }
    }
    
        return $this->render('partials/_header.html.twig', [
            "categoriesHigh" => $categories,
            'formInscription'=>$userForm->createView(),
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}
