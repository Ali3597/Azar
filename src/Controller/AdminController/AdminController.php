<?php

namespace App\Controller\AdminController;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class AdminController extends AbstractController
{


  
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {



        return $this->render('admin/index.html.twig', [
            
        ]);
    }

}
