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

                if ($this->IsThisBandeUnderVisible($bande->getBande())) {
                    $this->RearangePosition($bande->getBande());
                    $this->em->remove($bande->getBande());
                }
            }
            $this->em->flush();
        }
    }
    public function IsThisBandeUnderVisible($bande)
    {
        $visibleBande = $bande->getSlideVisible();
        $size = $bande->getItemLenght();
        if ($size - $visibleBande <= 0) {
            return true;
        }
        return false;
    }
    public function RearangePosition($bande)
    {
        $position = $bande->getPosition();
        $size = count($this->bandeRepo->findAll());
        for ($i = $position + 1; $i < $size; $i++) {
            $bandeToSet = $this->bandeRepo->findOneBandeByPosition($i);
            $bandeToSet->setPosition($i - 1);
            $this->em->persist($bandeToSet);
        }
    }
}
