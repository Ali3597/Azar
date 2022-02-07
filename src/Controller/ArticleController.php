<?php

namespace App\Controller;

use App\Entity\Article;

use App\Repository\ArticleRepository;
use App\Service\ViewCounter as ServiceViewCounter;
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
            3,
        );

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{slug}', name: 'article')]
    public function one(Article $article, ServiceViewCounter $viewCounter, Request $request): Response
    {
        if (!$article->getPublished()) {
            throw new Exception('Cette page n\'existe pas');
        }
        $ipUser = $request->getClientIp();

        $viewCounter->saveIt($ipUser, $article);

        return $this->render('article/one.html.twig', [
            'article' => $article,
        ]);
    }
}
