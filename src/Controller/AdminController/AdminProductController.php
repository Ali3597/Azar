<?php

namespace App\Controller\AdminController;

use App\Entity\Produit;
use App\Entity\Search;
use App\Form\ProduitType;
use App\Form\SearchType;
use App\Repository\ProduitRepository;
use App\Service\BandeManagement;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminProductController extends AbstractController
{
    private $productRepo;
    private $em;


    function __construct(ProduitRepository $productRepo, EntityManagerInterface $em)
    {
        $this->productRepo = $productRepo;
        $this->em = $em;
    }

    #[Route('/products', name: 'products')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $products = $paginator->paginate(
            $this->productRepo->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            3,
        );
        return $this->render('admin/admin_product/index.html.twig', [
            'products' => $products,
            "form" => $form->createView(),
        ]);
    }

    #[Route('/product/new', name: 'product_new')]
    public function new(Request $request): Response
    {
        $product = new Produit();
        $form = $this->createForm(ProduitType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($product);
            $this->em->flush();
            $this->addFlash('success', 'Votre produit a bien été ajouté ');
            return $this->redirectToRoute('admin_products');
        }

        return $this->render('admin/admin_product/new.html.twig', [
            'form' => $form->createview()
        ]);
    }


    #[Route('/product/{id}', name: 'product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $product): Response
    {
        $orginalsItemsDescription = null;
        if ($product->getDescriptionList()) {
            if ($product->getDescriptionList()->getItemList()) {
                $orginalsItemsDescription = new ArrayCollection();
                foreach ($product->getDescriptionList()->getItemList() as $item) {
                    $orginalsItemsDescription
                        ->add($item);
                }
            }
        }


        $orginalsItemsAdvice = null;
        if ($product->getAdvices()) {
            if ($product->getAdvices()->getItemAdviceList()) {
                $orginalsItemsAdvice = new ArrayCollection();
                foreach ($product->getAdvices()->getItemAdviceList() as $item) {
                    $orginalsItemsAdvice->add($item);
                }
            }
        }
        $product->setCategoryParent($product->getCategory()->getCategoryParent());
        $form = $this->createForm(ProduitType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($orginalsItemsDescription) {
                foreach ($orginalsItemsDescription as $item) {
                    if (false === $product->getDescriptionList()->getItemList()->contains($item)) {
                        $this->em->remove($item);
                    }
                }
            }
            if ($orginalsItemsAdvice) {
                foreach ($orginalsItemsAdvice as $item) {
                    if (false === $product->getAdvices()->getItemAdviceList()->contains($item)) {
                        $this->em->remove($item);
                    }
                }
            }
            $this->em->persist($product);
            $this->em->flush();
            $this->addFlash('success', 'Votre produit a bien été modifié ');
            return $this->redirectToRoute('admin_products');
        }

        return $this->render('admin/admin_product/edit.html.twig', [
            'form' => $form->createview(),
            'product' => $product
        ]);
    }


    #[Route('/product/{id}', name: 'product_delete', methods: ['DELETE'])]
    public function delete(Request $request, Produit $product, BandeManagement $bandeManagement): Response
    {

        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->get('_token'))) {
            $bandeManagement->deleteItemBande($product);
            foreach ($product->getPictures() as $image) {
                $product->removePicture($image);
                $this->em->remove($image);
            }
            $this->em->flush();
            $this->em->remove($product);
            $this->em->flush();
            $this->addFlash('success', 'Votre produit a bien été supprime ');
        }
        return $this->redirectToRoute('admin_products');
    }

    #[Route('/getProducts', name: 'ajax_products')]
    public function getHighCategories(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $products = $this->productRepo->findProductsinOneCategory($data["value"]);
        $test = [];

        for ($i = 0; $i < sizeof($products); $i++) {
            $test[$i] = ["name" => $products[$i]->getName(), "id" => $products[$i]->getId(), 'filename' => $products[$i]->getPictures()[0]->getFilename()];
        }
        return new JsonResponse(['categories' => $test]);
    }
}
