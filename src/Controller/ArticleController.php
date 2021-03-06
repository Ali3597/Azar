<?php

namespace App\Controller;

use App\Entity\Article;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{

    private $em;
    private $articleRepo;


    function __construct(EntityManagerInterface $em, ArticleRepository $articleRepo)
    {
        $this->em = $em;
        $this->articleRepo = $articleRepo;
    }

    #[Route('/articles', name: 'articles')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $articles = $paginator->paginate(
            $this->articleRepo->findAllArticlesPublishedByDates(),
            $request->query->getInt('page', 1),
            10,
        );

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{slug}', name: 'article')]
    public function one(Article $article): Response
    {
        if (!$article->getPublished()) {
            throw new Exception('Cette page n\'existe pas');
        }
      


        return $this->render('article/one.html.twig', [
            'article' => $article,
        ]);
    }
}
