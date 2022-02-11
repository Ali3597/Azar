<?php

namespace App\Service;

use App\Repository\StatViewRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;


class StatUse
{

    private $statViewRepo;
    private $em;
    public function __construct(StatViewRepository $statViewRepo, EntityManagerInterface $em)
    {
        $this->statViewRepo = $statViewRepo;
        $this->em = $em;
    }

    public function getWeeklyStat($data)
    {
        $year = $data["year"];
        $week = $data["week"];
        $graphStat = array();
        for ($i = 1; $i < 8; $i++) {
            $dateOfWeek = (new DateTime())->setISODate($year, $week, $i)->format('Y-m-d');
            $view = $this->statViewRepo->findByDate($dateOfWeek);
            array_push($graphStat, [$dateOfWeek, $view ? $view->getView() : null]);
        }
        return $graphStat;
    }
    public function getMonthlyStat($data)
    {
        $year = $data["year"];
        $month = $data["month"];
        $graphStat = array();
        $nbrDay = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($i = 1; $i < $nbrDay + 1; $i++) {
            $dateOfMonth = strval($year) . "-" . strval($month) . "-" . strval($i);
            $view = $this->statViewRepo->findByYearAndMonthAndDay($year, $month, $i);
            array_push($graphStat, [$dateOfMonth, $view ? $view->getView() : null]);
        }
        return $graphStat;
    }

    public function getYearlyStat($year)
    {
        $graphStat = array();
        for ($i = 1; $i < 13; $i++) {
            $nameOfMonth = strval($year) . "-" . strval($i);
            $view = $this->statViewRepo->findByYearAndMonth($year, $i);
            array_push($graphStat, [$nameOfMonth, $view ? $view : null]);
        }
        return $graphStat;
    }
}
