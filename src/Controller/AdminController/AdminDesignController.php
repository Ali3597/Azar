<?php

namespace App\Controller\AdminController;

use App\Form\DesignType;
use App\Repository\DesignRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDesignController extends AbstractController
{

    private $designRepo;
    private $em;


    function __construct(DesignRepository $designRepo, EntityManagerInterface $em)
    {
        $this->designRepo = $designRepo;
        $this->em = $em;
    }
    #[Route('/admin/design', name: 'admin_design')]
    public function index(Request $request): Response
    {
        $design = $this->designRepo->find(1);
        $logo = $design->getLogo();
        $aboutUSPicture = $design->getAboutUsPicture();
        $marquePicture = $design->getMarquePicture();
        $icon = $design->getIcon();
        $form = $this->createForm(DesignType::class, $design);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($design->getPictureFile()) {
                $this->em->remove($logo);
            }
            if ($design->getPictureFileAboutUs()) {
                $this->em->remove($aboutUSPicture);
            }
            if ($design->getPictureFileMarque()) {
                $this->em->remove($marquePicture);
            }
            if ($design->getPictureFileIcon()) {
                $this->em->remove($icon);
            }
            $this->em->persist($design);
            $this->em->flush();
            $this->addFlash('success', 'Votre Design a bie été modifié ');
            return $this->redirectToRoute('admin_design');
        }

        return $this->render('admin/admin_design/index.html.twig', [
            'controller_name' => 'AdminDesignController',
            'form' => $form->createView(),
            'design' => $design
        ]);
    }
}
