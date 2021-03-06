<?php

namespace App\Controller\AdminController;

use App\Entity\Article;
use App\Entity\Search;
use App\Form\ArticleType;
use App\Form\SearchType;
use App\Repository\ArticleRepository;

use App\Service\BandeManagement;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminArticleController extends AbstractController
{
    private $articleRepo;
    private $em;


    function __construct(ArticleRepository $articleRepo, EntityManagerInterface $em)
    {
        $this->articleRepo = $articleRepo;
        $this->em = $em;
    }

    #[Route('/articles', name: 'articles')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $articles = $paginator->paginate(
            $this->articleRepo->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            10,
        );

        return $this->render('admin/admin_article/index.html.twig', [
            'articles' => $articles,
            "form" => $form->createView(),
        ]);
    }

    #[Route('/article/new', name: 'article_new')]
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($article->getPicture()) {
                
                $article->setCreatedAt(new DateTimeImmutable('now'));
                $this->em->persist($article);
                $this->em->flush();
                $this->addFlash('success', 'Votre article a bien ??t?? ajout?? ');
                return $this->redirectToRoute('admin_articles');
            } else {
                $form->get("pictureFile")->addError(new FormError('Vous n\'avez pas mis de photo'));
            }
        }


        return $this->render('admin/new.html.twig', [
            'form' => $form->createview()
        ]);
    }


    #[Route('/article/{id}', name: 'article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, BandeManagement $bandeManagement): Response
    {

        $picture = $article->getPicture();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($article->getPictureFile()) {
                $this->em->remove($picture);
            }
            if ($article->getBandes() && !$article->getPublished()) {
                $bandeManagement->deleteItemBande($article);
                foreach ($article->getBandes() as $bandeArticle) {
                    $article->removeBande($bandeArticle);
                }
            }

            
            $this->em->persist($article);
            $this->em->flush();
            $this->addFlash('success', 'Votre article a bien ??t?? modifi?? ');
            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $form->createview(),
            'item' => $article
        ]);
    }


    #[Route('/article/{id}', name: 'article_delete', methods: ['DELETE'])]
    public function delete(Request $request, Article $article, BandeManagement $bandeManagement): Response
    {

        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->get('_token'))) {
            $bandeManagement->deleteItemBande($article);
          
            $this->em->flush();
            $this->em->remove($article);
            $this->em->flush();
            $this->addFlash('success', 'Votre article a bien ??t?? supprime ');
        }
        return $this->redirectToRoute('admin_articles');
    }

    #[Route('/getArticles', name: 'ajax_articles')]
    public function getArticles(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {

            $articles = $this->articleRepo->findAllArticlesPublishedByDates();
            $test = [];
            for ($i = 0; $i < sizeof($articles); $i++) {
                $test[$i] = ["name" => $articles[$i]->getTitle(), "id" => $articles[$i]->getId(), "filename" => $articles[$i]->getPicture()->getFilename()];
            }

            return new JsonResponse(['articles' => $test]);
        } else {
            throw new Exception('Cette page n\'existe pas');
        }
    }
}
