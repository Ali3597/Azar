<?php

namespace App\Controller;

use App\Repository\DesignRepository;
use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarqueController extends AbstractController
{

    private $em;
    private $marqueRepo;


    function __construct(EntityManagerInterface $em, MarqueRepository $marqueRepo)
    {
        $this->em = $em;
        $this->marqueRepo = $marqueRepo;
    }
    #[Route('/marque', name: 'marque')]
    public function index(DesignRepository $designRepo): Response
    {
        $design = $designRepo->find(1);
        $marques = $this->marqueRepo->findAll();
        return $this->render('marque/index.html.twig', [
            'marques' => $marques,
            'design' => $design
        ]);
    }
}
