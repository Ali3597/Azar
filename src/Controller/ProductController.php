<?php

namespace App\Controller;

use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private $em;
    private $productRepo;


    function __construct(EntityManagerInterface $em, ProduitRepository $productRepo)
    {
        $this->em = $em;
        $this->productRepo = $productRepo;
    }
    #[Route('/produit/{id}', name: 'produit')]
    public function index(): Response
    {
        $marques = $this->productRepo->findAll();
        return $this->render('marque/index.html.twig', [
            'marques' => $marques,
        ]);
    }
}
