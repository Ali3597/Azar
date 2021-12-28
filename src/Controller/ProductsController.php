<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Marque;
use App\Repository\CategoryRepository;
use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{


    private $em;
    private $productRepo;


    function __construct(EntityManagerInterface $em, ProduitRepository $productRepo)
    {
        $this->em = $em;
        $this->productRepo = $productRepo;
    }

    #[Route('/produits/recherche/{q}', name: 'productsSearch')]
    public function search($q, PaginatorInterface $paginator, Request $request): Response
    {
        $marqueSlug = $request->query->get("marque") ? $request->query->get("marque") : "none";

        if ($marqueSlug == 'Sans_Marque') {
            $marqueSlug = null;
        }
        $search = $q;
        $categorySlug  = $request->query->get("categorie");
        if ($request->isXmlHttpRequest()) {
            $products = $this->productRepo->findProductsDependsOnParameters($categorySlug, $search, $marqueSlug);
            $PaginateProducts = $paginator->paginate(
                $products,
                $request->query->getInt('page', 1),
                1,
            );
            return $this->render('products/productsList.html.twig', [
                'products' => $PaginateProducts,
            ]);
        } else {



            $activeFilter = 0;
            $productsGlobal = $this->productRepo->findProductsDependsOnSearch($search);
            if ($categorySlug || $marqueSlug != "none") {

                $products = $this->productRepo->findProductsDependsOnParameters($categorySlug, $search, $marqueSlug);
            } else {
                $products = $productsGlobal;
            }

            $PaginateProducts = $paginator->paginate(
                $products,
                $request->query->getInt('page', 1),
                1,
            );

            $marques = [];
            $categories = [];
            foreach ($productsGlobal as $value) {
                $marqueName = $value->getMarque() ? $value->getMarque()->getName() : "Sans Marque";
                if (isset($marques[$marqueName])) {
                    $marques[$marqueName]["nbr"] += 1;
                } else {
                    $marques[$marqueName] = array(
                        "nbr" => 1,
                        "slug" => $value->getMarque() ? $value->getMarque()->getSlug() : "Sans_Marque"
                    );
                }

                $categoryName = $value->getCategory()->getName();
                if (isset($categories[$categoryName])) {
                    $categories[$categoryName]["nbr"] += 1;
                } else {
                    $categories[$categoryName] = array(
                        "nbr" => 1,
                        "slug" => $value->getCategory()->getSlug()
                    );
                }
            }
            return $this->render('products/index.html.twig', [
                'activeFilter' => $activeFilter,
                'products' => $PaginateProducts,
                'marques' => $marques,
                'categories' => $categories,
                "category" => null,
                "search" => $q,
                "marque" => null,
            ]);
        }
    }


    #[Route('/produits/marque/{slug}', name: 'productsMarques')]
    public function marque(Marque $marque, PaginatorInterface $paginator, Request $request, MarqueRepository $marqueRepos, CategoryRepository $categoryRepo): Response
    {
        $categorySlug  = $request->query->get("categorie");
        $marqueSlug = $marque->getSlug();
        if ($request->isXmlHttpRequest()) {
            $products = $this->productRepo->findProductsDependsOnParameters($categorySlug, null, $marqueSlug);
            $PaginateProducts = $paginator->paginate(
                $products,
                $request->query->getInt('page', 1),
                1,
            );
            return $this->render('products/productsList.html.twig', [
                'products' => $PaginateProducts,
            ]);
        } else {

            $activeFilter = 0;
            $productsGlobal = $this->productRepo->findProductsDependsOnMarqueSlug($marqueSlug);

            if ($categorySlug) {
                $products = $this->productRepo->findProductsDependsOnParameters($categorySlug, null, $marqueSlug);
            } else {
                $products = $productsGlobal;
            }
            $PaginateProducts = $paginator->paginate(
                $products,
                $request->query->getInt('page', 1),
                1,
            );


            $categories = [];
            foreach ($productsGlobal as $value) {
                $categoryName = $value->getCategory()->getName();
                if (isset($categories[$categoryName])) {
                    $categories[$categoryName]["nbr"] += 1;
                } else {
                    $categories[$categoryName] = array(
                        "nbr" => 1,
                        "slug" => $value->getCategory()->getSlug()
                    );
                }
            }
            return $this->render('products/index.html.twig', [
                'activeFilter' => $activeFilter,
                'products' => $PaginateProducts,
                'marques' => null,
                'categories' => $categories,
                "category" => null,
                "search" => null,
                "marque" => $marque,
            ]);
        }
    }
    #[Route('/produits/categorie/{slug}', name: 'productsCategories')]
    public function index(Category $category, PaginatorInterface $paginator, Request $request, MarqueRepository $marqueRepos, CategoryRepository $categoryRepo): Response
    {
        $marqueSlug = $request->query->get("marque") ? $request->query->get("marque") : "none";

        if ($marqueSlug == 'Sans_Marque') {
            $marqueSlug = null;
        }
        $categorySlug  = $category->getSlug();
        if ($request->isXmlHttpRequest()) {
            $products = $this->productRepo->findProductsDependsOnParameters($categorySlug, null, $marqueSlug);
            $PaginateProducts = $paginator->paginate(
                $products,
                $request->query->getInt('page', 1),
                1,
            );
            return $this->render('products/productsList.html.twig', [
                'products' => $PaginateProducts,
            ]);
        } else {

            $activeFilter = 0;
            $productsGlobal = $this->productRepo->findProductsDependsOnCategorySlug($categorySlug);

            if ($marqueSlug) {
                $products = $this->productRepo->findProductsDependsOnParameters($categorySlug, null, $marqueSlug);
            } else {
                $products = $productsGlobal;
            }
            $PaginateProducts = $paginator->paginate(
                $products,
                $request->query->getInt('page', 1),
                1,
            );


            $marques = [];
            foreach ($productsGlobal as $value) {
                $marqueName = $value->getMarque() ? $value->getMarque()->getName() : "Sans Marque";
                if (isset($marques[$marqueName])) {
                    $marques[$marqueName]["nbr"] += 1;
                } else {
                    $marques[$marqueName] = array(
                        "nbr" => 1,
                        "slug" => $value->getMarque() ? $value->getMarque()->getSlug() : "Sans_Marque"
                    );
                }
            }
            return $this->render('products/index.html.twig', [
                'activeFilter' => $activeFilter,
                'products' => $PaginateProducts,
                'marques' => $marques,
                'categories' => null,
                "category" => $category,
                "search" => null,
                "marque" => null,
            ]);
        }
    }
}
