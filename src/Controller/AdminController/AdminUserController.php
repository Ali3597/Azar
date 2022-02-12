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

#[Route('/admin', name: 'admin_')]
class AdminUserController extends AbstractController
{
    private $userRepo;
    private $em;


    function __construct(UserRepository $userRepo, EntityManagerInterface $em)
    {
        $this->userRepo = $userRepo;
        $this->em = $em;
    }
    #[Route('/users', name: 'users')]
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

    #[Route('/user/consult/{id}', name: 'user_consult')]
    public function consult(User $user, Request $request): Response
    {


        return $this->render('admin/admin_user/consult.html.twig', [
            'user' => $user,

        ]);
    }
    #[Route('/user/envies/{id}', name: 'user_want')]
    public function want(User $user, Request $request, PaginatorInterface $paginator, ProduitRepository $produitRepo): Response
    {

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $products  = $paginator->paginate(
            $produitRepo->findUserWantingsWithSearch($user->getId(), $search),
            $request->query->getInt('page', 1),
            3,
        );


        return $this->render('admin/admin_user/want.html.twig', [
            'user' => $user,
            'products' => $products,
            'form' => $form->createView()
        ]);
    }
    #[Route('/user/commands/{id}', name: 'user_command')]
    public function command(User $user, Request $request, PaginatorInterface $paginator, CommandRepository $commandRepo): Response
    {

        $commands  = $paginator->paginate(
            $commandRepo->findUserCommands($user->getId()),
            $request->query->getInt('page', 1),
            3,
        );

        return $this->render('admin/admin_user/command.html.twig', [
            'user' => $user,
            "commands" => $commands,
            "form" => false

        ]);
    }

    #[Route('/user/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(User $user, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))) {
            foreach ($user->getCommands() as $command) {
                $this->em->remove($command);
            }
            $this->em->flush();
            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success', 'Votre utilisateur a bien été supprime ');
        }
        return $this->redirectToRoute('admin_users');
    }
}
