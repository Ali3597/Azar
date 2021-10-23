<?php

namespace App\Controller\AdminController;

use App\Entity\Category;
use App\Entity\Search;
use App\Form\HighCategoryType;
use App\Form\SearchType as FormSearchType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminHighCategoryController extends AbstractController
{

    private $categorieRepo;
    private $em;
   

    function __construct(CategoryRepository $categorieRepo,EntityManagerInterface $em)
    {
        $this->categorieRepo = $categorieRepo;
        $this->em = $em;
    }

    #[Route('/high_categories', name: 'high_categories')]
    public function index(PaginatorInterface $paginator , Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(FormSearchType::class, $search);
        $form->handleRequest($request);
        $highCategories= $paginator->paginate(
            $this->categorieRepo->findHighCategoriesQueryWithSearch($search),
            $request->query->getInt('page', 1),
            3,
        );
        return $this->render('admin/admin_high_category/index.html.twig', [
            'categories' => $highCategories,
            "form" => $form->createView(),
        ]);
    }
    #[Route('/high_category/new', name: 'high_category_new')]
    public function new(Request $request): Response
    {
        $categorie = new Category();
        $form = $this->createForm(HighCategoryType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($categorie);
            $this->em->flush();
            $this->addFlash('success', 'Votre categorie a bien été ajouté ');
            return $this->redirectToRoute('admin_high_categories');
        }

        return $this->render('admin/admin_high_category/new.html.twig', [
            'form' => $form->createview()
        ]);
    }
    #[Route('/high_category/consult/{id}', name: 'high_category_consult')]
    public function consult(PaginatorInterface $paginator , Request $request ,Category $category): Response
    {
        $search = new Search();
        $form = $this->createForm(FormSearchType::class, $search);
        $form->handleRequest($request);
        $lowCategories= $paginator->paginate(
            $this->categorieRepo->findCategoriesChildrensQueryWithSearch($search,$category->getId()),
            $request->query->getInt('page', 1),
            3,
        );
        return $this->render('admin/admin_high_category/consult.html.twig', [
            'categories' => $lowCategories,
            'highCategory'=>$category,
            'form'=>$form->createView()
        ]);
    }

    #[Route('/high_category/{id}', name: 'high_category_edit', methods: ['GET', 'POST'])]
    public function edit( Request $request,Category $category): Response
    {
        $form = $this->createForm(HighCategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->em->persist($category);
            $this->em->flush();
            $this->addFlash('success', 'Votre categorie a bien été modifié ');
            return $this->redirectToRoute('admin_high_categories');
        }

        return $this->render('admin/admin_high_category/edit.html.twig', [
            'form' => $form->createview()
        ]);
    }


    #[Route('/high_category/{id}', name: 'high_category_delete', methods: ['DELETE'])]
    public function delete(Request $request , Category $categorie): Response
    {
      
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->get('_token'))) 
        {
            $this->em->remove($categorie);
            $this->em->flush();
            $this->addFlash('success', 'Votre categorie a bien été supprime ');
        }
        return $this->redirectToRoute('admin_high_categories');

    }

    

}
