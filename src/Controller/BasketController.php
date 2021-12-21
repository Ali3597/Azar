<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(SessionInterface $session, ProduitRepository $produitRepo): Response
    {
        $basket =  $session->get("basket", null);
        $products = [];
        foreach ($basket as $key => $value) {
            $product = $produitRepo->find($key);
            $product->setBasketNumber($value);
            array_push($products, $product);
        }

        return $this->render('basket/index.html.twig', [
            'basket' => $basket,
            'products' => $products
        ]);
    }

    #[Route('/panier/add/{id}', name: 'panier_add')]
    public function add(Produit $product, SessionInterface $session, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $nbr = $data["nbrProducts"];
        $id = $product->getId();
        $basket =  $session->get("basket");
        $totalNumber = $session->get("total", 0);
        $totalNumber += $nbr;
        if (isset($basket[$id])) {
            $basket[$id] += $nbr;
            if ($basket[$id] == 0) {
                unset($basket[$id]);
            }
        } else {
            $basket[$id] = $nbr;
        }
        $session->set("total", $totalNumber);
        $session->set("basket", $basket);

        return new JsonResponse(['nbr' => $totalNumber]);
    }
}
