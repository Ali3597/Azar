<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\BandeArticle;
use App\Entity\BandeCategory;
use App\Entity\BandeCategoryTitle;
use App\Entity\Category;
use App\Entity\Marque;
use App\Repository\BandeRepository;
use Doctrine\ORM\EntityManagerInterface;

class BandeManagement
{

    function __construct(BandeRepository $bandeRepo, EntityManagerInterface $em)
    {
        $this->bandeRepo = $bandeRepo;
        $this->em = $em;
    }
    public function deleteItemBande($item)
    {

        $bandes =  $item->getBandes();

        if ($bandes) {
            foreach ($bandes as $bande) {

                $this->em->remove($bande->getBande());
            }
            $this->em->flush();
        }
    }
}
