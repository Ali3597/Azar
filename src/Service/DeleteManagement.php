<?php

namespace App\Service;


use App\Repository\BandeRepository;
use App\Repository\ComandProductsRepository;
use App\Repository\ViewCounterRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteManagement
{
    function __construct(BandeRepository $bandeRepo, EntityManagerInterface $em, BandeManagement $bandeManagement, ComandProductsRepository $comandProductsRepo, ViewCounterRepository $viewCounterRepo)
    {
        $this->bandeRepo = $bandeRepo;
        $this->em = $em;
        $this->BandeManagement = $bandeManagement;
        $this->comandProductsRepo = $comandProductsRepo;
        $this->viewCounterRepo = $viewCounterRepo;
    }
    public function deleteProduct($product)
    {
        $this->bandeManagement->deleteItemBande($product);
        foreach ($product->getPictures() as $image) {
            $product->removePicture($image);
            $this->em->remove($image);
        }
        $commandProducts =  $this->comandProductsRepo->findCommandByproductId($product->getId());

        foreach ($commandProducts as $commandProduct) {
            $oneCommand =  $commandProduct->getCommands();
            $this->em->remove($commandProduct);
            if (count($oneCommand->getComandProducts()) == 1) {
                $this->em->remove($oneCommand);
            };
        }

        $viewsOfTheProduct = $this->viewCounterRepo->findbyProductId($product->getId());
        foreach ($viewsOfTheProduct as $view) {
            $this->em->remove($view);
        }
        $this->em->flush();
        $this->em->remove($product);
        $this->em->flush();
    }
   
}
