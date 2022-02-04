<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\BandeRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Repository\CategoryRepository;
use App\Repository\DesignRepository;
use App\Security\LoginFormAuthenticator;
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
use Tchoulom\ViewCounterBundle\Counter\ViewCounter as Counter;

class RecycleController extends AbstractController
{

    private $em;


    function __construct(EntityManagerInterface $em, Counter $viewCounter)
    {
        $this->em = $em;
        $this->viewcounter = $viewCounter;
    }




    public function header(Request $request, SessionInterface $session, DesignRepository $designRepo, UserAuthenticatorInterface $authenticator, LoginFormAuthenticator $loginForm, UserPasswordHasherInterface $passwordHasher, AuthenticationUtils $authenticationUtils, CategoryRepository $categoryRepo, MailerInterface $mailer): Response
    {

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


        // view
        $viewcounter = $this->viewcounter->getViewCounter($design);
        if ($this->viewcounter->isNewView($viewcounter)) {
            $views = $this->viewcounter->getViews($design);
            $viewcounter->setIp($request->getClientIp());
            $viewcounter->setDesign($design);
            $viewcounter->setViewDate(new \DateTime('now'));

            $design->setViews($views);

            $this->em->persist($viewcounter);
            $this->em->persist($design);
            $this->em->flush();
        }
        // $viewcounter = $this->viewcounter->getViewCounter($product);
        // if ($this->viewcounter->isNewView($viewcounter)) {
        //     $views = $this->viewcounter->getViews($product);
        //     $viewcounter->setIp($request->getClientIp());
        //     $viewcounter->setProduit($product);
        //     $viewcounter->setViewDate(new \DateTime('now'));

        //     $product->setViews($views);

        //     $this->em->persist($viewcounter);
        //     $this->em->persist($product);
        //     $this->em->flush();
        // }

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
