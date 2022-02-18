<?php

namespace App\Service;


use App\Repository\BandeRepository;
use App\Repository\ComandProductsRepository;
use App\Repository\CommandRepository;

use App\Service\BandeManagement;
use Doctrine\ORM\EntityManagerInterface;

class DeleteManagement
{
    function __construct(BandeRepository $bandeRepo, EntityManagerInterface $em, BandeManagement $bandeManagement, CommandRepository $commandRepo)
    {
        $this->bandeRepo = $bandeRepo;
        $this->em = $em;
        $this->bandeManagement = $bandeManagement;
        $this->commandRepo = $commandRepo;
       
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
        
    
      
        $this->em->flush();
     
        $this->em->remove($product);
        $this->em->flush();
    
    }
   
}
