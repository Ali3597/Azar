<?php

namespace App\Controller\AdminController;

use App\Entity\Command;
use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\CommandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommandController extends AbstractController
{

    private $commandRepo;
    private $em;


    function __construct(CommandRepository $commandRepo, EntityManagerInterface $em)
    {
        $this->commandRepo = $commandRepo;
        $this->em = $em;
    }
    #[Route('/admin/commands', name: 'admin_commands')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $commands = $paginator->paginate(
            $this->commandRepo->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            3,
        );



        return $this->render('admin/admin_command/index.html.twig', [
            'commands' => $commands,
            "form" => $form->createView(),
        ]);
    }

    #[Route('/admin/commands/consult/{id}', name: 'admin_command_consult')]
    public function consult(Command $command): Response
    {








        return $this->render('admin/admin_command/consult.html.twig', [
            'command' => $command,

        ]);
    }

    #[Route('/command/{id}', name: 'admin_command_delete', methods: ['DELETE'])]
    public function delete(): Response
    {
        dd("todooooo");
        // if ($this->isCsrfTokenValid('delete' . $marque->getId(), $request->get('_token'))) {
        //     foreach ($marque->getProduits() as $product) {
        //         $marque->removeProduit($product);
        //     }
        //     $this->em->remove($marque);
        //     $this->em->flush();
        //     $this->addFlash('success', 'Votre marque a bien été supprime ');
        // }
        // return $this->redirectToRoute('admin_marques');
    }
}
