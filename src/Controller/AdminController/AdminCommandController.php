<?php

namespace App\Controller\AdminController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommandController extends AbstractController
{
    #[Route('/admin/commands', name: 'admin_commands')]
    public function index(): Response
    {
        return $this->render('admin/admin_command/index.html.twig', [
            'controller_name' => 'AdminCommandController',
        ]);
    }
}
