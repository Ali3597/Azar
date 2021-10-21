<?php

namespace App\Controller\AdminController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMarqueController extends AbstractController
{
    #[Route('/admin/marques', name: 'admin_marques')]
    public function index(): Response
    {
        return $this->render('admin/admin_marque/index.html.twig', [
            'controller_name' => 'AdminMarqueController',
        ]);
    }
}
