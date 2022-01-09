<?php

namespace App\Controller\AdminController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    #[Route('/admin/users', name: 'admin_users')]
    public function index(): Response
    {
        return $this->render('admin/admin_user/index.html.twig', [
            'controller_name' => 'AdminCommandController',
        ]);
    }
}
