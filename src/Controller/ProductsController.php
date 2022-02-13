<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Marque;
use App\Repository\CategoryRepository;
use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function xmlHttpRequestLoad($paginator, $categorySlug, $search, $marqueSlug, $order, $request)
    {
        $products = $this->productRepo->findProductsDependsOnParameters($categorySlug, $search, $marqueSlug, $order);
        $PaginateProducts = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            12,
        );
        return $this->render('products/productsList.html.twig', [
            'products' => $PaginateProducts,
        ]);
    }
    public function fillArrayMarquesAndCategories($productsGlobal, $marques, $categories)
    {
        foreach ($productsGlobal as $value) {
            if (is_array($marques)) {

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
            if (is_array($categories)) {
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
        }
        return [$marques, $categories];
    }


    public function howManyActiveFilter($categorySlug, $marqueSlug)
    {
    }

    #[Route('/produits/recherche/{q}', name: 'productsSearch')]
    public function search($q, PaginatorInterface $paginator, Request $request): Response
    {
        $marqueSlugData = $request->query->get("marque") ? $request->query->get("marque") : "none";
        $order = $request->query->get("order");
        $search = $q;
        $category = null;
        $marque = null;
        if ($marqueSlugData == 'Sans_Marque') {
            $marqueSlug = null;
        } else {
            $marqueSlug = $marqueSlugData;
        }
        $categorySlug  = $request->query->get("categorie");
        if ($request->isXmlHttpRequest()) {
            return $this->xmlHttpRequestLoad($paginator, $categorySlug, $search, $marqueSlug, $order, $request);
        }
        $activeFilter = 0;
        if ($categorySlug) {
            $activeFilter += 1;
        }
        if ($marqueSlug != "none") {
            $activeFilter += 1;
        }
        $productsGlobal = $this->productRepo->findProductsDependsOnSearch($search, $order);
        if ($categorySlug || $marqueSlug != "none") {

            $products = $this->productRepo->findProductsDependsOnParameters($categorySlug, $search, $marqueSlug, $order);
        } else {
            $products = $productsGlobal;
        }

        $PaginateProducts = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            12,
        );
        [$marques, $categories] = $this->fillArrayMarquesAndCategories($productsGlobal, [], []);
        return $this->render('products/index.html.twig', [
            'activeFilter' => $activeFilter,
            'products' => $PaginateProducts,
            'marques' => $marques,
            'categories' => $categories,
            "category" => $category,
            "search" => $q,
            "marque" => $marque,
            "marqueSlug" => $marqueSlugData,
            "categorySlug" => $categorySlug,
            "order" => $order
        ]);
    }


    #[Route('/produits/marque/{slug}', name: 'productsMarques')]
    public function marque(Marque $marque, PaginatorInterface $paginator, Request $request, MarqueRepository $marqueRepos, CategoryRepository $categoryRepo): Response
    {
        $categorySlug  = $request->query->get("categorie");
        $order = $request->query->get("order");
        $marqueSlug = $marque->getSlug();
        $search = null;
        $category = null;
        if ($request->isXmlHttpRequest()) {
            return $this->xmlHttpRequestLoad($paginator, $categorySlug, $search, $marqueSlug, $order, $request);
        }

        $activeFilter = 0;
        if ($categorySlug) {
            $activeFilter += 1;
        }

        $productsGlobal = $this->productRepo->findProductsDependsOnMarqueSlug($marqueSlug, $order);

        if ($categorySlug) {
            $products = $this->productRepo->findProductsDependsOnParameters($categorySlug, $search, $marqueSlug, $order);
        } else {
            $products = $productsGlobal;
        }
        $PaginateProducts = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            12,
        );
        [$marques, $categories] = $this->fillArrayMarquesAndCategories($productsGlobal, null, []);
        return $this->render('products/index.html.twig', [
            'activeFilter' => $activeFilter,
            'products' => $PaginateProducts,
            'marques' => $marques,
            'categories' => $categories,
            "category" => $category,
            "search" => $search,
            "marque" => $marque,
            "marqueSlug" => null,
            "categorySlug" => $categorySlug,
            "order" => $order
        ]);
    }
    #[Route('/produits/categorie/{slug}', name: 'productsCategories')]
    public function index(Category $category, PaginatorInterface $paginator, Request $request, MarqueRepository $marqueRepos, CategoryRepository $categoryRepo): Response
    {
        $marqueSlugData = $request->query->get("marque") ? $request->query->get("marque") : "none";
        $order = $request->query->get("order");
        $search = null;
        if ($marqueSlugData == 'Sans_Marque') {
            $marqueSlug = null;
        } else {
            $marqueSlug = $marqueSlugData;
        }
        $categorySlug  = $category->getSlug();
        if ($request->isXmlHttpRequest()) {
            return $this->xmlHttpRequestLoad($paginator, $categorySlug, $search, $marqueSlug, $order, $request);
        }

        $activeFilter = 0;

        if ($marqueSlug != "none") {
            $activeFilter += 1;
        }
        $productsGlobal = $this->productRepo->findProductsDependsOnCategorySlug($categorySlug, $order);
        if ($marqueSlug != "none") {
            $products = $this->productRepo->findProductsDependsOnParameters($categorySlug, $search, $marqueSlug, $order);
        } else {
            $products = $productsGlobal;
        }
        $PaginateProducts = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            12,
        );


        [$marques, $categories] = $this->fillArrayMarquesAndCategories($productsGlobal, [], null);
        return $this->render('products/index.html.twig', [
            'activeFilter' => $activeFilter,
            'products' => $PaginateProducts,
            'marques' => $marques,
            'categories' => $categories,
            "category" => $category,
            "search" => null,
            "marque" => null,
            "marqueSlug" => $marqueSlugData,
            "categorySlug" => null,
            "order" => $order
        ]);
    }
}
