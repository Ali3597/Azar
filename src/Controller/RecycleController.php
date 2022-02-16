<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\CommandRepository;
use App\Repository\DesignRepository;

use App\Service\ViewCounter;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class RecycleController extends AbstractController
{

    private $em;


    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }




    public function header(Request $request,CommandRepository $commandRepository, ViewCounter $viewCounter, SessionInterface $session, DesignRepository $designRepo,  AuthenticationUtils $authenticationUtils, CategoryRepository $categoryRepo): Response
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


        // // view
        $ipUser = $request->getClientIps();
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
