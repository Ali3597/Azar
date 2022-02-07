<?php

namespace App\Repository;

use App\Entity\BandeCategoryTitle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BandeCategoryTitle|null find($id, $lockMode = null, $lockVersion = null)
 * @method BandeCategoryTitle|null findOneBy(array $criteria, array $orderBy = null)
 * @method BandeCategoryTitle[]    findAll()
 * @method BandeCategoryTitle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BandeCategoryTitleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BandeCategoryTitle::class);
    }

    // /**
    //  * @return BandeCategoryTitle[] Returns an array of BandeCategoryTitle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findBandeByItemId($id)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.categories', 'c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?BandeCategoryTitle
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
