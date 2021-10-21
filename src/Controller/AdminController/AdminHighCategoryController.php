<?php

namespace App\Controller\AdminController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHighCategoryController extends AbstractController
{
    #[Route('/admin/high_categories', name: 'admin_high_categories')]
    public function index(): Response
    {
        return $this->render('admin/admin_high_category/index.html.twig', [
            'controller_name' => 'AdminHighCategoryController',
        ]);
    }
}
