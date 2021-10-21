<?php

namespace App\Controller\AdminController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDesignController extends AbstractController
{
    #[Route('/admin/design', name: 'admin_design')]
    public function index(): Response
    {
        return $this->render('admin/admin_design/index.html.twig', [
            'controller_name' => 'AdminDesignController',
        ]);
    }
}
