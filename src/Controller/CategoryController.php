<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoryController extends AbstractController
{


    private $em;
    private $categoryRepo;


    function __construct(EntityManagerInterface $em, CategoryRepository $categoryRepo)
    {
        $this->em = $em;
        $this->categoryRepo = $categoryRepo;
    }


    #[Route('/categorie/{slug}', name: 'category')]
    public function one(Category $category): Response
    {
        if ($category->getCategoryParent()) {
            throw new Exception('Cette page n\'existe pas');
        } else {

            return $this->render('category/one.html.twig', [
                "category" => $category,
            ]);
        }
    }
    #[Route('/getLowCategories', name: 'ajax_lowCategories')]
    public function getHighCategories(Request $request, CategoryRepository $categoryRepo): Response
    {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(), true);
            $categories = $categoryRepo->findAllLowCategoriesofCategoryParent($data["value"]);
            $test = [];
            $i = 0;
            foreach ($categories as $category) {
                if ($category->doYouHaveProductsWhoHaveAfficher()) {
                    $test[$i] = ["name" => $category->getName(), "slug" => $category->getSlug(), 'id' => $category->getId()];
                    $i += 1;
                }
            }
            return new JsonResponse(['categories' => $test]);
        } else {
            throw new Exception('Cette page n\'existe pas');
        }
    }
}
