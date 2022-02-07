<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\ViewCounter as ServiceViewCounter;
use Exception;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends AbstractController
{

    private $em;
    private $productRepo;


    function __construct(EntityManagerInterface $em, ProduitRepository $productRepo)
    {
        $this->em = $em;

        $this->productRepo = $productRepo;
    }
    #[Route('/produit/{slug}', name: 'produit')]
    public function index(Produit $product, ProduitRepository $produitRepo, Request $request, ServiceViewCounter $viewCounter): Response
    {

        if (!$product->getAfficher()) {
            throw new Exception('Cette page n\'existe pas');
        }
        $productsAlike =  $produitRepo->findFourProductsDependsOnCategoryId($product->getCategory()->getId(), $product->getId());

        // view 
        $ipUser = $request->getClientIp();

        $viewCounter->saveIt($ipUser, $product);

        return $this->render('product/index.html.twig', [
            'product' => $product,
            'alikes' => $productsAlike
        ]);
    }
}
