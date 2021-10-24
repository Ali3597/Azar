<?php

namespace App\Controller\AdminController;

use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminPictureController extends AbstractController
{

    function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }

    #[Route('/picture/{id}', name: 'picture_delete',methods: ['DELETE'])]
    public function index(Request $request, Picture $picture): Response
    {

       $data =json_decode($request->getContent(),true);
        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $data['_token'])) 
        {
            $this->em->remove($picture);
            $this->em->flush();
            $this->addFlash('success', 'Votre image a bien été supprime ');
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
        
    }
}
