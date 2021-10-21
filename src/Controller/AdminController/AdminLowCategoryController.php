<?php

namespace App\Controller\AdminController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLowCategoryController extends AbstractController
{
    #[Route('/admin/low_categories', name: 'admin_low_categories')]
    public function index(): Response
    {
        return $this->render('admin/admin_low_category/index.html.twig', [
            'controller_name' => 'AdminLowCategoryController',
        ]);
    }
}
