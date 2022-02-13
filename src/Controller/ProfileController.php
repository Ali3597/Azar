<?php

namespace App\Controller;

use App\Entity\UserPassword;
use App\Form\UserChangeType;
use App\Form\UserPasswordProfileType;
use App\Repository\CommandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;




class ProfileController extends AbstractController
{
    private $em;


    function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }
    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }



    #[Route("/profile/commandes", name: "commande_valide")]
    public function commands(PaginatorInterface $paginator,CommandRepository $commandRepo,Request $request): Response
    {
        $currentUser = $this->getUser();
        $commands = $paginator->paginate(
            $commandRepo->findUserCommands($currentUser->getId()),
            $request->query->getInt('page', 1),
            2,
        );
        return $this->render('user/commands.html.twig', [

          'commands' => $commands
        ]);
    }


    #[Route("/profile/commande/{id}", name: "commande_one")]
    public function command($id,CommandRepository $commandRepo, Request $request): Response
    {
        $currentUser = $this->getUser();
        $command = $commandRepo->findOneCommandByUSerAndCommandId($id,$currentUser->getId());
        if($command==null){
            return $this->redirectToRoute('commande_valide');
        }
        return $this->render('user/oneCommand.html.twig', [

            'command' => $command
        ]);
    }



    #[Route('/profile/parametres', name: 'parameters')]
    public function parameters(Request $request, UserPasswordHasherInterface $passwordHasher, TokenStorageInterface $tokenStorageInterface): Response
    {

        $user = $this->getUser();
        $userPassword =  new UserPassword();
        $passwordForm  = $this->createForm(UserPasswordProfileType::class, $userPassword);
        $passwordForm->handleRequest($request);
        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $datas = $passwordForm->getData();
            $actualPassword = $userPassword->getActualPassword();
            $newPassword = $datas["newPassword"];
            $confirmPassword = $datas["confirmPassword"];
            $verifyHash = $passwordHasher->isPasswordValid($user, $actualPassword);
            if ($verifyHash) {
                $hash = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hash);
                $this->em->persist($user);
                $this->em->flush();
                $this->addFlash('success', 'Votre mot de passe a bien été modifié ');
            } else {
                $passwordForm->get('actualPassword')->addError(new FormError('Le mot de passe n\'est pas valide'));
            }
        }
        $changeForm = $this->createForm(UserChangeType::class, $user);
        $changeForm->handleRequest($request);
        if ($changeForm->isSubmitted() && $changeForm->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Vos informations  ont  bien été modifié ');
        }


        return $this->render('user/parameters.html.twig', [
            'passwordForm' => $passwordForm->createView(),
            'changeForm' => $changeForm->createView()
        ]);
    }
}
