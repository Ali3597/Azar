<?php

namespace App\Controller\AdminController;

use App\Entity\Category;
use App\Entity\Search;
use App\Form\LowCategoryType;
use App\Form\SearchType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminLowCategoryController extends AbstractController
{
    private $categorieRepo;
    private $em;
   

    function __construct(CategoryRepository $categorieRepo,EntityManagerInterface $em)
    {
        $this->categorieRepo = $categorieRepo;
        $this->em = $em;
    }

    #[Route('/low_categories', name: 'low_categories')]
    public function index(PaginatorInterface $paginator , Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $lowCategories= $paginator->paginate(
            $this->categorieRepo->findLowCategoriesQueryWithSearch($search),
            $request->query->getInt('page', 1),
            3,
        );

        return $this->render('admin/admin_low_category/index.html.twig', [
            'categories' => $lowCategories,
            "form" => $form->createView(),
        ]);
    }

    #[Route('/low_category/new', name: 'low_category_new')]
    public function new(Request $request): Response
    {
        $categorie = new Category();
        $form = $this->createForm(LowCategoryType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($categorie);
            $this->em->flush();
            $this->addFlash('success', 'Votre categorie a bien été ajouté ');
            return $this->redirectToRoute('admin_low_categories');
        }

        return $this->render('admin/admin_low_category/new.html.twig', [
            'form' => $form->createview()
        ]);
    }

    // #[Route('/low_category/consult/{id}', name: 'low_category_consult')]
    // public function consult(PaginatorInterface $paginator , Request $request ,Category $category): Response
    // {
    //     $search = new Search();
    //     $form = $this->createForm(FormSearchType::class, $search);
    //     $form->handleRequest($request);
    //     $lowCategories= $paginator->paginate(
    //         $this->categorieRepo->findCategoriesChildrensQueryWithSearch($search,$category->getId()),
    //         $request->query->getInt('page', 1),
    //         3,
    //     );
    //     return $this->render('admin/admin_low_category/consult.html.twig', [
    //         'categories' => $lowCategories,
    //         'lowCategory'=>$category,
    //         'form'=>$form->createView()
    //     ]);
    // }

    #[Route('/low_category/{id}', name: 'low_category_edit', methods: ['GET', 'POST'])]
    public function edit( Request $request,Category $category): Response
    {
        $form = $this->createForm(LowCategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->em->persist($category);
            $this->em->flush();
            $this->addFlash('success', 'Votre categorie a bien été modifié ');
            return $this->redirectToRoute('admin_low_categories');
        }

        return $this->render('admin/admin_low_category/edit.html.twig', [
            'form' => $form->createview()
        ]);
    }


    #[Route('/low_category/{id}', name: 'low_category_delete', methods: ['DELETE'])]
    public function delete(Request $request , Category $categorie): Response
    {
      
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->get('_token'))) 
        {
            $this->em->remove($categorie);
            $this->em->flush();
            $this->addFlash('success', 'Votre categorie a bien été supprime ');
        }
        return $this->redirectToRoute('admin_low_categories');

    }

    #[Route('/getLowCategories', name: 'ajax_lowCategories')]
    public function getHighCategories(Request $request): Response
    {
        $data = json_decode($request->getContent(),true);
      $categories = $this->categorieRepo->findAllLowCategoriesofCategoryParent($data["value"]);
        $test= [];
        for ($i= 0;$i < sizeof($categories) ;$i++) {
            $test[$i]= ["name"=>$categories[$i]->getName(),"id"=>$categories[$i]->getId()];
        }
    return new JsonResponse(['categories' => $test]);
         
        
    }
}
