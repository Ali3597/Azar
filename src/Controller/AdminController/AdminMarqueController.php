<?php

namespace App\Controller\AdminController;

use App\Entity\Marque;
use App\Entity\Search;
use App\Form\MarqueType;
use App\Form\SearchType;
use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminMarqueController extends AbstractController
{
    private $marqueRepo;
    private $em;
   

    function __construct(MarqueRepository $marqueRepo,EntityManagerInterface $em)
    {
        $this->marqueRepo = $marqueRepo;
        $this->em = $em;
    }

    #[Route('/marques', name: 'marques')]
    public function index(PaginatorInterface $paginator , Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $marques= $paginator->paginate(
            $this->marqueRepo->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            3,
        );
        return $this->render('admin/admin_marque/index.html.twig', [
            'marques' => $marques,
            "form" => $form->createView(),
        ]);
    }

    #[Route('/marque/new', name: 'marque_new')]
    public function new(Request $request): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($marque);
            $this->em->flush();
            $this->addFlash('success', 'Votre marque a bien été ajouté ');
            return $this->redirectToRoute('admin_marques');
        }

        return $this->render('admin/admin_marque/new.html.twig', [
            'form' => $form->createview()
        ]);
    }


    #[Route('/marque/{id}', name: 'marque_edit', methods: ['GET', 'POST'])]
    public function edit( Request $request,Marque $marque): Response
    {
        $picture = $marque->getPicture();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($marque->getPictureFile()) {
                $this->em->remove($picture);
            }
            $this->em->persist($marque);
            $this->em->flush();
            $this->addFlash('success', 'Votre Marque a bien été modifié ');
            return $this->redirectToRoute('admin_marques');
        }

        return $this->render('admin/admin_marque/edit.html.twig', [
            'form' => $form->createview(),
            'marque'=>$marque
        ]);
    }


    #[Route('/marque/{id}', name: 'marque_delete', methods: ['DELETE'])]
    public function delete(Request $request , Marque $marque): Response
    {
    
        if ($this->isCsrfTokenValid('delete'.$marque->getId(), $request->get('_token'))) 
        {
            $this->em->remove($marque);
            $this->em->flush();
            $this->addFlash('success', 'Votre marque a bien été supprime ');
        }
        return $this->redirectToRoute('admin_marques');

    }
}