<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ViewCounter as EntityViewCounter;
use App\Form\UserType;
use App\Repository\BandeRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Repository\CategoryRepository;
use App\Repository\DesignRepository;
use App\Repository\StatViewRepository;
use App\Repository\ViewCounterRepository;
use App\Security\LoginFormAuthenticator;
use App\Service\StatUse;
use App\Service\ViewCounter;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Else_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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




    public function header(StatUse $statUse, Request $request, ViewCounter $viewCounter, SessionInterface $session, DesignRepository $designRepo, UserAuthenticatorInterface $authenticator, LoginFormAuthenticator $loginForm, UserPasswordHasherInterface $passwordHasher, AuthenticationUtils $authenticationUtils, CategoryRepository $categoryRepo, MailerInterface $mailer): Response
    {


        // dd($statUse->getWeeklyStat(["year" => 2022, "week" => 05]));
        // dd($statUse->getMonthlyStat(["year" => 2022, "month" => 02]));
        dd($statUse->getYearlyStat(2022));
        $categories = $categoryRepo->findAllHighCategories();

        //logo
        $design = $designRepo->find(1);

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        //inscription
        $user =  new User();
        $userForm = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('inscription'),
        ]);

        //basket
        $totalNumber = $session->get("total", 0);
        $basket = $session->get("basket", null);


        // // view
        $ipUser = $request->getClientIp();
        $viewCounter->saveIt($ipUser, $design);



        return $this->render('partials/_header.html.twig', [
            "categoriesHigh" => $categories,
            'formInscription' => $userForm->createView(),
            'last_username' => $lastUsername,
            'design' => $design,
            'total' => $totalNumber,
            "basket" => $basket
        ]);
    }
}
