<?php

namespace App\Repository;

use App\Entity\StatView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatView|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatView|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatView[]    findAll()
 * @method StatView[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatViewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatView::class);
    }

    // /**
    //  * @return StatView[] Returns an array of StatView objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatView
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByYearAndMonth($year, $month)
    {
        return $this->createQueryBuilder('s')
            ->Where('YEAR(s.day) = :year')
            ->setParameter('year', $year)
            ->andWhere('MONTH(s.day) = :month')
            ->setParameter('month', $month)
            ->select('SUM(s.view)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function findByDate($date)
    {
        return $this->createQueryBuilder('s')
            ->Where('s.day = :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByYearAndMonthAndDay($year, $month, $day)
    {
        return $this->createQueryBuilder('s')
            ->Where('Year(s.day) = :year')
            ->setParameter('year', $year)
            ->andWhere('Month(s.day) = :month')
            ->setParameter('month', $month)
            ->andWhere('Day(s.day) = :day')
            ->setParameter('day', $day)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
