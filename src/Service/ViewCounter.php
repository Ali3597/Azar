<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Design;
use App\Entity\Produit;
use App\Entity\StatView;
use App\Entity\ViewCounter as EntityViewCounter;
use App\Repository\StatViewRepository;
use App\Repository\ViewCounterRepository;

use Doctrine\ORM\EntityManagerInterface;

class ViewCounter
{

    private $viewCounterRepo;
    private $em;
    public function __construct(ViewCounterRepository $viewCounterRepo, EntityManagerInterface $em)
    {
        $this->viewCounterRepo = $viewCounterRepo;
        $this->em = $em;
    }

    public function isNewView($ip, $item)
    {
        if ($item instanceof Produit) {
            $type = "product";
        } elseif ($item instanceof Article) {
            $type = "article";
        } elseif ($item instanceof Design) {

            $type = "design";
        }
        $result = $this->viewCounterRepo->findByIpAndInstanceID($item, $ip, $type);

        return $result;
    }
    public function saveIt($ip, $item)
    {

        if (!$this->isNewView($ip, $item)) {
            $view = new EntityViewCounter;
            $view->setIp($ip);
            $view->setEntity($item);
            $view->setViewDate(new \DateTime('now'));
            $item->addOneView();
            $this->em->persist($view);
            $this->em->persist($item);
            $this->em->flush();
        }
    }

    public function commandCron()
    {
        $view = $this->viewCounterRepo->CountAllview();
        $statView = new StatView();
        $statView->setView($view);
        $statView->setDay(new \DateTime('now'));
        $this->em->persist($statView);
        $this->em->flush();
        $this->viewCounterRepo->deleteAll();
    }
}
