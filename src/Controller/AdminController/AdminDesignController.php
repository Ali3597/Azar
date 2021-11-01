<?php

namespace App\Controller\AdminController;

use App\Repository\DesignRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDesignController extends AbstractController
{

    private $designRepo;
    private $em;
   

    function __construct(DesignRepository $designRepo,EntityManagerInterface $em)
    {
        $this->designRepo= $designRepo;
        $this->em = $em;
    }
    #[Route('/admin/design', name: 'admin_design')]
    public function index(): Response
    {
        $design  = $this->designRepo->find(1);
        
        return $this->render('admin/admin_design/index.html.twig', [
            'design' => $design,
            'controller_name' => 'AdminDesignController',
        ]);
    }
}
