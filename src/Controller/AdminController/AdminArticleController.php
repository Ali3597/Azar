<?php

namespace App\Controller\AdminController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{
    #[Route('/admin/articles', name: 'admin_articles')]
    public function index(): Response
    {
        return $this->render('admin/admin_article/index.html.twig', [
            'controller_name' => 'AdminArticleController',
        ]);
    }
}
