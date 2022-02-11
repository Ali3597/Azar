<?php

namespace App\Controller\AdminController;

use App\Entity\Search;
use App\Entity\User;
use App\Form\SearchType;
use App\Repository\CommandRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    private $userRepo;
    private $em;


    function __construct(UserRepository $userRepo, EntityManagerInterface $em)
    {
        $this->userRepo = $userRepo;
        $this->em = $em;
    }
    #[Route('/admin/users', name: 'admin_users')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $users = $paginator->paginate(
            $this->userRepo->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            10,
        );


        return $this->render('admin/admin_user/index.html.twig', [
            'users' => $users,
            "form" => $form->createView(),
        ]);
    }

    #[Route('/admin/user/consult/{id}', name: 'admin_user_consult')]
    public function consult(User $user, Request $request): Response
    {


        return $this->render('admin/admin_user/consult.html.twig', [
            'user' => $user,

        ]);
    }
    #[Route('/admin/user/envies/{id}', name: 'admin_user_want')]
    public function want(User $user, Request $request, PaginatorInterface $paginator, ProduitRepository $produitRepo): Response
    {

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $products  = $paginator->paginate(
            $produitRepo->findUserWantingsWithSearch($user->getId(), $search),
            $request->query->getInt('page', 1),
            10,
        );


        return $this->render('admin/admin_user/want.html.twig', [
            'user' => $user,
            'products' => $products,
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/user/commands/{id}', name: 'admin_user_command')]
    public function command(User $user, Request $request, PaginatorInterface $paginator, CommandRepository $commandRepo): Response
    {

        $commands  = $paginator->paginate(
            $commandRepo->findUserCommands($user->getId()),
            $request->query->getInt('page', 1),
            10,
        );

        return $this->render('admin/admin_user/command.html.twig', [
            'user' => $user,
            "commands" => $commands

        ]);
    }
}
