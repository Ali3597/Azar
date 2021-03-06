<?php

namespace App\Controller\AdminController;

use App\Entity\Category;
use App\Entity\Search;
use App\Form\HighCategoryType;
use App\Form\SearchType as FormSearchType;
use App\Repository\CategoryRepository;
use App\Service\BandeManagement;
use App\Service\DeleteManagement;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin', name: 'admin_')]
class AdminHighCategoryController extends AbstractController
{

    private $categorieRepo;
    private $em;


    function __construct(CategoryRepository $categorieRepo, EntityManagerInterface $em)
    {
        $this->categorieRepo = $categorieRepo;
        $this->em = $em;
    }

    #[Route('/high_categories', name: 'high_categories')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(FormSearchType::class, $search);
        $form->handleRequest($request);
        $highCategories = $paginator->paginate(
            $this->categorieRepo->findHighCategoriesQueryWithSearch($search),
            $request->query->getInt('page', 1),
            10,
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
            if ($categorie->getPicture()) {
                $this->em->persist($categorie);
                $this->em->flush();
                $this->addFlash('success', 'Votre categorie a bien ??t?? ajout?? ');
                return $this->redirectToRoute('admin_high_categories');
            } else {
                $form->get("pictureFile")->addError(new FormError('Vous n\'avez pas mis de photo'));
            }
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createview()
        ]);
    }
    #[Route('/high_category/consult/{id}', name: 'high_category_consult')]
    public function consult(PaginatorInterface $paginator, Request $request, Category $category): Response
    {

        $search = new Search();
        $form = $this->createForm(FormSearchType::class, $search);
        $form->handleRequest($request);
        $lowCategories = $paginator->paginate(
            $this->categorieRepo->findCategoriesChildrensQueryWithSearch($search, $category->getId()),
            $request->query->getInt('page', 1),
            10,
        );
        return $this->render('admin/admin_high_category/consult.html.twig', [
            'categories' => $lowCategories,
            'highCategory' => $category,
            'form' => $form->createView()
        ]);
    }

    #[Route('/high_category/{id}', name: 'high_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category): Response
    {
        $picture = $category->getPicture();
        $form = $this->createForm(HighCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($category->getPictureFile()) {
                $this->em->remove($picture);
            }
            $this->em->persist($category);
            $this->em->flush();
            $this->addFlash('success', 'Votre categorie a bien ??t?? modifi?? ');
            return $this->redirectToRoute('admin_high_categories');
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $form->createview(),
            'item' => $category,
        ]);
    }


    #[Route('/high_category/{id}', name: 'high_category_delete', methods: ['DELETE'])]
    public function delete(Request $request, Category $categorie, BandeManagement $bandeManagement,DeleteManagement $deleteManagement): Response
    {

        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->get('_token'))) {
            $bandeManagement->deleteItemBande($categorie);
            $categoriesChildren = $categorie->getCategoriesChildrens();
            foreach ($categoriesChildren as $element) {
                $productsElement = $element->getProduits();
                foreach($productsElement as $productElement){
                    $deleteManagement->deleteProduct($productElement);
                    
                }
               
                $this->em->remove($element);
            }
           
            $this->em->flush();
            $this->em->remove($categorie);
            $this->em->flush();
            $this->addFlash('success', 'Votre categorie a bien ??t?? supprim?? ');
        }
        return $this->redirectToRoute('admin_high_categories');
    }



    #[Route('/getHighCategories', name: 'ajax_highCategories')]
    public function getHighCategories(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $categories = $this->categorieRepo->findAllHighCategories();
            $test = [];
            for ($i = 0; $i < sizeof($categories); $i++) {
                $test[$i] = ["name" => $categories[$i]->getName(), "id" => $categories[$i]->getId(), "filename" => $categories[$i]->getPicture()->getFilename()];
            }
            return new JsonResponse(['categories' => $test]);
        } else {
            throw new Exception('Cette page n\'existe pas');
        }
    }
}
