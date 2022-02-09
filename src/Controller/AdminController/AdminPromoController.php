<?php

namespace App\Controller\AdminController;

use App\Entity\Promo;
use App\Entity\Search;
use App\Form\PromoType;
use App\Form\SearchType;
use App\Repository\PromoRepository;
use App\Service\BandeManagement;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminPromoController extends AbstractController
{
    private $promoRepo;
    private $em;


    function __construct(PromoRepository $promoRepo, EntityManagerInterface $em)
    {
        $this->promoRepo = $promoRepo;
        $this->em = $em;
    }

    #[Route('/promos', name: 'promos')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $promos = $paginator->paginate(
            $this->promoRepo->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            3,
        );
        return $this->render('admin/admin_promo/index.html.twig', [
            'promos' => $promos,
            "form" => $form->createView(),
        ]);
    }

    #[Route('/promo/new', name: 'promo_new')]
    public function new(Request $request): Response
    {
        $promo = new Promo();
        $form = $this->createForm(PromoType::class, $promo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($promo);
            $this->em->flush();
            $this->addFlash('success', 'Votre promo a bien été ajouté ');
            return $this->redirectToRoute('admin_promos');
        }

        return $this->render('admin/admin_promo/new.html.twig', [
            'form' => $form->createview()
        ]);
    }


    #[Route('/promo/{id}', name: 'promo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Promo $promo): Response
    {
        $picture = $promo->getPicture();
        $form = $this->createForm(PromoType::class, $promo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($promo->getPictureFile()) {
                $this->em->remove($picture);
            }
            $this->em->persist($promo);
            $this->em->flush();
            $this->addFlash('success', 'Votre promo a bien été modifié ');
            return $this->redirectToRoute('admin_promos');
        }

        return $this->render('admin/admin_promo/edit.html.twig', [
            'form' => $form->createview(),
            'promo' => $promo
        ]);
    }


    #[Route('/promo/{id}', name: 'promo_delete', methods: ['DELETE'])]
    public function delete(Request $request, Promo $promo, BandeManagement $bandeManagement): Response
    {

        if ($this->isCsrfTokenValid('delete' . $promo->getId(), $request->get('_token'))) {
            $bandeManagement->deleteItemBande($promo);
            $this->em->remove($promo);
            $this->em->flush();
            $this->addFlash('success', 'Votre promo a bien été supprime ');
        }
        return $this->redirectToRoute('admin_promos');
    }


    #[Route('/getPromos', name: 'ajax_promos')]
    public function getPromos(Request $request): Response
    {

        if ($request->isXmlHttpRequest()) {
            $promos = $this->promoRepo->findAllPromosAlphabet();
            $test = [];
            for ($i = 0; $i < sizeof($promos); $i++) {
                $test[$i] = ["name" => $promos[$i]->getName(), "id" => $promos[$i]->getId(), "filename" => $promos[$i]->getPicture()->getFilename()];
            }
            return new JsonResponse(['promos' => $test]);
        } else {
            throw new Exception('Cette page n\'existe pas');
        }
    }
}
