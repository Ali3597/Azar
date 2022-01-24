<?php

namespace App\Service;

use App\Repository\DesignRepository;
use Doctrine\ORM\EntityManagerInterface;

class ColorManagement
{

    function __construct(DesignRepository $designRepo, EntityManagerInterface $em)
    {
        $this->designRepo = $designRepo;
        $this->em = $em;
    }
    public function getAllColors()
    {
        $design = $this->designRepo->find(1);

        $colors = [
            'primary' => $design->getPrimaryColor(),
            'secondary' => $design->getSencondaryColor()
        ];
        return $colors;
    }
}
