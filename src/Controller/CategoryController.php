<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\BandeRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CategoryController extends AbstractController
{

   
    private $em;
    private $categoryRepo;
   

    function __construct(EntityManagerInterface $em,CategoryRepository $categoryRepo)
    {
        $this->em = $em;
        $this->categoryRepo = $categoryRepo;
    }
    #[Route('/categories/{letter}', name: 'categories' ,requirements: ['letter' => '([A-Za-z*]){1}'])]
    public function index( string $letter="A"): Response
    {
       $letter = strtoupper($letter);
       $categories= $this->categoryRepo->findHighCategoriesBeginWith($letter);
       

    
        return $this->render('category/index.html.twig', [
            "categories"=>$categories,
            "letter" =>$letter,
        ]);
    }

    #[Route('/category/{slug}', name: 'category' )]
    public function one(Category $category ): Response
    {

       

    
        return $this->render('category/one.html.twig', [
            "category"=>$category,
        ]);
    }
}
