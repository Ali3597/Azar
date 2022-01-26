<?php

namespace App\Controller\AdminController;

use App\Entity\Bande;
use App\Entity\BandeArticle;
use App\Entity\BandeCategory;
use App\Entity\BandeCategoryTitle;
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
    public function valid(Request $request, ProduitRepository $produitRepo, PromoRepository $promoRepo, ArticleRepository $articleRepo, CategoryRepository $categoryRepo, MarqueRepository $marqueRepo): Response
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
            $bande->setTitle($dataBande["title"]);
            $bande->setSubtitle($dataBande["subtitle"]);
            $bande->setColor($dataBande["color"]);
            if ($bande->getType() == "product") {
                $bande->setSlideVisible(4);
                $bande->setSlideToScroll(1);
                $this->em->persist($bande);
                $bandeProduct = new BandeProduct();
                $bandeProduct->setBande($bande);
                foreach ($dataBande["elements"] as $elementId) {
                    $product = $produitRepo->find($elementId);
                    $bandeProduct->addProduct($product);
                }
                $this->em->persist($bandeProduct);
            } else if ($bande->getType() == "category") {
                $bande->setSlideVisible(1);
                $bande->setSlideToScroll(1);
                $this->em->persist($bande);
                $bandeCategory = new BandeCategory();
                $bandeCategory->setBande($bande);
                foreach ($dataBande["elements"] as $elementId) {
                    $category = $categoryRepo->find($elementId);
                    $bandeCategory->addCategory($category);
                }
                $this->em->persist($bandeCategory);
            } else if ($bande->getType() == "marque") {
                $bande->setSlideVisible(8);
                $bande->setSlideToScroll(2);
                $this->em->persist($bande);
                $bandeMarque = new BandeMarque();
                $bandeMarque->setBande($bande);
                foreach ($dataBande["elements"] as $elementId) {
                    $marque = $marqueRepo->find($elementId);
                    $bandeMarque->addMarque($marque);
                }
                $this->em->persist($bandeMarque);
            } else if ($bande->getType() == "article") {
                $bande->setSlideVisible(3);
                $bande->setSlideToScroll(1);
                $this->em->persist($bande);
                $bandeArticle = new BandeArticle();
                $bandeArticle->setBande($bande);
                foreach ($dataBande["elements"] as $elementId) {
                    $article = $articleRepo->find($elementId);
                    $bandeArticle->addArticle($article);
                }
                $this->em->persist($bandeArticle);
            } else if ($bande->getType() == "promo") {
                $bande->setSlideVisible(1);
                $bande->setSlideToScroll(1);
                $this->em->persist($bande);
                $bandePromo = new BandePromo();
                $bandePromo->setBande($bande);
                foreach ($dataBande["elements"] as $elementId) {
                    $promo = $promoRepo->find($elementId);
                    $bandePromo->addPromo($promo);
                }
                $this->em->persist($bandePromo);
            } else if ($bande->getType() == "categoryTitle") {
                $bande->setSlideVisible(3);
                $bande->setSlideToScroll(1);
                $this->em->persist($bande);
                $bandeCategoryTitle = new BandeCategoryTitle();
                $bandeCategoryTitle->setBande($bande);
                foreach ($dataBande["elements"] as $elementId) {
                    $category = $categoryRepo->find($elementId);
                    $bandeCategoryTitle->addCategory($category);
                }
                $this->em->persist($bandeCategoryTitle);
            }
            $this->em->flush();
        }
        return new JsonResponse(['message' => "ok"]);
    }
}
