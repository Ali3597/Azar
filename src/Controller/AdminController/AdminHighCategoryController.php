<?php

namespace App\Controller\AdminController;

use App\Entity\Category;
use App\Entity\Search;
use App\Form\HighCategoryType;
use App\Form\SearchType as FormSearchType;
use App\Repository\CategoryRepository;
use App\Service\BandeManagement;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

#[Route('/admin', name: 'admin_')]
class AdminHighCategoryController extends AbstractController
{

    private $categorieRepo;
    private $em;


    function __construct(CategoryRepository $categorieRepo, EntityManagerInterface $em)
    {
        $this->categorieRepo = $categorieRepo;
        $this->em = $em;
    }

    #[Route('/high_categories', name: 'high_categories')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(FormSearchType::class, $search);
        $form->handleRequest($request);
        $highCategories = $paginator->paginate(
            $this->categorieRepo->findHighCategoriesQueryWithSearch($search),
            $request->query->getInt('page', 1),
            3,
        );
        return $this->render('admin/admin_high_category/index.html.twig', [
            'categories' => $highCategories,
            "form" => $form->createView(),
        ]);
    }
    #[Route('/high_category/new', name: 'high_category_new')]
    public function new(Request $request): Response
    {
        $categorie = new Category();
        $form = $this->createForm(HighCategoryType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($categorie->getPicture()) {
                $this->em->persist($categorie);
                $this->em->flush();
                $this->addFlash('success', 'Votre categorie a bien été ajouté ');
                return $this->redirectToRoute('admin_high_categories');
            } else {
                $form->get("pictureFile")->addError(new FormError('Vous n\'avez pas mis de photo'));
            }
        }

        return $this->render('admin/admin_high_category/new.html.twig', [
            'form' => $form->createview()
        ]);
    }
    #[Route('/high_category/consult/{id}', name: 'high_category_consult')]
    public function consult(PaginatorInterface $paginator, Request $request, Category $category): Response
    {

        $search = new Search();
        $form = $this->createForm(FormSearchType::class, $search);
        $form->handleRequest($request);
        $lowCategories = $paginator->paginate(
            $this->categorieRepo->findCategoriesChildrensQueryWithSearch($search, $category->getId()),
            $request->query->getInt('page', 1),
            3,
        );
        return $this->render('admin/admin_high_category/consult.html.twig', [
            'categories' => $lowCategories,
            'highCategory' => $category,
            'form' => $form->createView()
        ]);
    }

    #[Route('/high_category/{id}', name: 'high_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category): Response
    {
        $picture = $category->getPicture();
        $form = $this->createForm(HighCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($category->getPictureFile()) {
                $this->em->remove($picture);
            }
            $this->em->persist($category);
            $this->em->flush();
            $this->addFlash('success', 'Votre categorie a bien été modifié ');
            return $this->redirectToRoute('admin_high_categories');
        }

        return $this->render('admin/admin_high_category/edit.html.twig', [
            'form' => $form->createview(),
            'category' => $category,
        ]);
    }


    #[Route('/high_category/{id}', name: 'high_category_delete', methods: ['DELETE'])]
    public function delete(Request $request, Category $categorie, BandeManagement $bandeManagement): Response
    {

        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->get('_token'))) {
            $bandeManagement->deleteItemBande($categorie);
            $categoriesChildren = $categorie->getCategoriesChildrens();
            foreach ($categoriesChildren as $element) {
                $this->em->remove($element);
            }
            $this->em->flush();
            $this->em->remove($categorie);
            $this->em->flush();
            $this->addFlash('success', 'Votre categorie a bien été supprimé ');
        }
        return $this->redirectToRoute('admin_high_categories');
    }



    #[Route('/getHighCategories', name: 'ajax_highCategories')]
    public function getHighCategories(Request $request): Response
    {
        $categories = $this->categorieRepo->findAllHighCategories();
        $test = [];
        for ($i = 0; $i < sizeof($categories); $i++) {
            $test[$i] = ["name" => $categories[$i]->getName(), "id" => $categories[$i]->getId(), "filename" => $categories[$i]->getPicture()->getFilename()];
        }
        return new JsonResponse(['categories' => $test]);
    }
}
