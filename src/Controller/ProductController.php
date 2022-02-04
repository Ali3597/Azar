<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ViewCounter;
use Symfony\Component\HttpFoundation\Request;
use Tchoulom\ViewCounterBundle\Counter\ViewCounter as Counter;

class ProductController extends AbstractController
{

    private $em;
    private $productRepo;


    function __construct(EntityManagerInterface $em, ProduitRepository $productRepo, Counter $viewCounter)
    {
        $this->em = $em;
        $this->viewcounter = $viewCounter;
        $this->productRepo = $productRepo;
    }
    #[Route('/produit/{slug}', name: 'produit')]
    public function index(Produit $product, ProduitRepository $produitRepo, Request $request): Response
    {
        $productsAlike =  $produitRepo->findFourProductsDependsOnCategoryId($product->getCategory()->getId(), $product->getId());

        // view 

        $viewcounter = $this->viewcounter->getViewCounter($product);
        if ($this->viewcounter->isNewView($viewcounter)) {
            $views = $this->viewcounter->getViews($product);
            $viewcounter->setIp($request->getClientIp());
            $viewcounter->setProduit($product);
            $viewcounter->setViewDate(new \DateTime('now'));
            $product->setViews($views);
            $this->em->persist($viewcounter);
            $this->em->persist($product);
            $this->em->flush();
        }
        return $this->render('product/index.html.twig', [
            'product' => $product,
            'alikes' => $productsAlike
        ]);
    }
}
