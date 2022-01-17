<?php

namespace App\Controller\AdminController;

use App\Entity\Command;
use App\Entity\Search;
use App\Form\CommandType;
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
    public function consult(Command $command, Request $request): Response
    {

        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($command);
            $this->em->flush();
            $this->addFlash('success', 'Votre commande a bien été modifié ');
        }
        return $this->render('admin/admin_command/consult.html.twig', [
            'command' => $command,
            'form' => $form->createView()
        ]);
    }


    #[Route('/command/{id}', name: 'admin_command_delete', methods: ['DELETE'])]
    public function delete(Command $command, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $command->getId(), $request->get('_token'))) {

            $this->em->remove($command);
            $this->em->flush();
            $this->addFlash('success', 'Votre commande a bien été supprime ');
        }
        return $this->redirectToRoute('admin_commands');
    }
}
