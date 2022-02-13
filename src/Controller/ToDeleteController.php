<?php

namespace App\Controller;

use App\Entity\Design;
use App\Form\DesignType;
use App\Repository\DesignRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDeleteController extends AbstractController
{

    private $designRepo;
    private $em;


    function __construct(DesignRepository $designRepo, EntityManagerInterface $em)
    {
        $this->designRepo = $designRepo;
        $this->em = $em;
    }
    #[Route('/todelete', name: 'toDelete')]
    public function index(Request $request): Response
    {
        $design = new Design();

        $form = $this->createForm(DesignType::class, $design);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $design->setViews(0);
            $this->em->persist($design);
            $this->em->flush();
            $this->addFlash('success', 'Votre Design a bien été crée ');
            return $this->redirectToRoute('admin_design');
        }

        return $this->render('to_delete/index.html.twig', [

            'form' => $form->createView(),

        ]);
    }
}
