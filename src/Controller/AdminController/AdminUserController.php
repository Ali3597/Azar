<?php

namespace App\Controller\AdminController;

use App\Entity\Search;
use App\Form\SearchType;
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
            3,
        );


        return $this->render('admin/admin_user/index.html.twig', [
            'users' => $users,
            "form" => $form->createView(),
        ]);
    }
}
