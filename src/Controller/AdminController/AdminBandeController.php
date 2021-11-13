<?php

namespace App\Controller\AdminController;

use App\Entity\Bande;
use App\Entity\BandeArticle;
use App\Entity\BandeCategory;
use App\Entity\BandeMarque;
use App\Entity\BandeProduct;
use App\Entity\BandePromo;
use App\Repository\ArticleRepository;
use App\Repository\BandeRepository;
use App\Repository\CategoryRepository;
use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;
use App\Repository\PromoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBandeController extends AbstractController
{

    private $bandeRepo;
    private $em;


    function __construct(BandeRepository $bandeRepo, EntityManagerInterface $em)
    {
        $this->bandeRepo = $bandeRepo;
        $this->em = $em;
    }
    #[Route('/admin/bandes', name: 'admin_bandes')]
    public function index(): Response
    {
        $bandes  = $this->bandeRepo->findAllBandesByPosition();
        return $this->render('admin/admin_bande/index.html.twig', [
            'bandes' => $bandes,
        ]);
    }


    #[Route('/admin/validNewBandes', name: 'admin_validNewBandes')]
    public function valid(Request $request, ProduitRepository $produitRepo,PromoRepository $promoRepo , ArticleRepository $articleRepo,CategoryRepository $categoryRepo, MarqueRepository $marqueRepo): Response
    {
        $data = json_decode($request->getContent(), true);
        $bandes  = $this->bandeRepo->findAll();
        foreach ($bandes as $bande) {
            $this->em->remove($bande);
        }
        foreach ($data["bandesToSendHttp"] as $dataBande) {
            $bande = new Bande();
            $bande->setType($dataBande["type"]);
            $bande->setPosition($dataBande["position"]);
            $bande->setSlideVisible($dataBande["visible"]);
            $bande->setSlideToScroll($dataBande["scroll"]);
            $bande->setTitle($dataBande["title"]);
            $bande->setSubtitle($dataBande["subtitle"]);
            $this->em->persist($bande);
            if ($bande->getType() == "product") {
                $bandeProduct = new BandeProduct();
                $bandeProduct->setBande($bande);
                foreach ($dataBande["elements"] as $elementId) {
                    $product = $produitRepo->find($elementId);
                    $bandeProduct->addProduct($product);
                }
            $this->em->persist($bandeProduct);
            } else if ($bande->getType() == "category") {
                $bandeCategory = new BandeCategory();
                $bandeCategory->setBande($bande);
                foreach ($dataBande["elements"] as $elementId) {
                    $category = $categoryRepo->find($elementId);
                    $bandeCategory->addCategory($category);
                }
            $this->em->persist($bandeCategory);
            } else if ($bande->getType() == "marque") {
                $bandeMarque = new BandeMarque();
                $bandeMarque->setBande($bande);
                foreach ($dataBande["elements"] as $elementId) {
                    $marque = $marqueRepo->find($elementId);
                    $bandeMarque->addMarque($marque);
                }
            $this->em->persist($bandeMarque);
            } else if ($bande->getType() == "article") {
                $bandeArticle = new BandeArticle();
                $bandeArticle->setBande($bande);
                foreach ($dataBande["elements"] as $elementId) {
                    $article = $articleRepo->find($elementId);
                    $bandeArticle->addArticle($article);
                }
            $this->em->persist($bandeArticle);
            } else if ($bande->getType() == "promo") {
                $bandePromo = new BandePromo();
                $bandePromo->setBande($bande);
                foreach ($dataBande["elements"] as $elementId) {
                    $promo = $promoRepo->find($elementId);
                    $bandePromo->addPromo($promo);
                }
            $this->em->persist($bandePromo);
            }
            $this->em->flush();
        }
        return new JsonResponse(['message' =>"ok"]);
     
    }
}