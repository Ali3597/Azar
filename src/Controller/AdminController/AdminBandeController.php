<?php

namespace App\Controller\AdminController;

use App\Repository\BandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBandeController extends AbstractController
{

    private $bandeRepo;
    private $em;
   

    function __construct(BandeRepository $bandeRepo,EntityManagerInterface $em)
    {
        $this->bandeRepo= $bandeRepo;
        $this->em = $em;
    }
    #[Route('/admin/bandes', name: 'admin_bandes')]
    public function index(): Response
    {
        $bandes  = $this->bandeRepo->findAllBandesByPosition();
        return $this->render('admin/admin_bande/index.html.twig', [
            'bandes' => $bandes,
        ]);
    }
}
