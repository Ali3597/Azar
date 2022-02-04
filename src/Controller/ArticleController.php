<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Tchoulom\ViewCounterBundle\Counter\ViewCounter as Counter;

class ArticleController extends AbstractController
{

    private $em;
    private $articleRepo;


    function __construct(EntityManagerInterface $em, ArticleRepository $articleRepo, Counter $viewCounter)
    {
        $this->em = $em;
        $this->articleRepo = $articleRepo;
        $this->viewcounter = $viewCounter;
    }

    #[Route('/articles', name: 'articles')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $articles = $paginator->paginate(
            $this->articleRepo->findAllArticlesByDates(),
            $request->query->getInt('page', 1),
            3,
        );

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{slug}', name: 'article')]
    public function one(Article $article, Request $request): Response
    {

        $viewcounter = $this->viewcounter->getViewCounter($article);
        if ($this->viewcounter->isNewView($viewcounter)) {
            $views = $this->viewcounter->getViews($article);
            $viewcounter->setIp($request->getClientIp());
            $viewcounter->setArticle($article);
            $viewcounter->setViewDate(new \DateTime('now'));
            $article->setViews($views);
            $this->em->persist($viewcounter);
            $this->em->persist($article);
            $this->em->flush();
        }
        return $this->render('article/one.html.twig', [
            'article' => $article,
        ]);
    }
}
