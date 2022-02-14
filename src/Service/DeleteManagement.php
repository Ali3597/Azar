<?php

namespace App\Service;


use App\Repository\BandeRepository;
use App\Repository\ComandProductsRepository;
use App\Repository\CommandRepository;
use App\Repository\ViewCounterRepository;
use App\Service\BandeManagement;
use Doctrine\ORM\EntityManagerInterface;

class DeleteManagement
{
    function __construct(BandeRepository $bandeRepo, EntityManagerInterface $em, BandeManagement $bandeManagement, CommandRepository $commandRepo, ViewCounterRepository $viewCounterRepo)
    {
        $this->bandeRepo = $bandeRepo;
        $this->em = $em;
        $this->bandeManagement = $bandeManagement;
        $this->commandRepo = $commandRepo;
        $this->viewCounterRepo = $viewCounterRepo;
    }
    public function deleteProduct($product)
    {
        $this->bandeManagement->deleteItemBande($product);
        foreach ($product->getPictures() as $image) {
            $product->removePicture($image);
            $this->em->remove($image);
        }
        $commands =  $this->commandRepo->findProductCommands($product->getId());

        foreach ($commands as $command) {
            $this->em->remove($command);
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
