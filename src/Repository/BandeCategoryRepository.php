<?php

namespace App\Repository;

use App\Entity\BandeCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BandeCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BandeCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BandeCategory[]    findAll()
 * @method BandeCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BandeCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BandeCategory::class);
    }

    // /**
    //  * @return BandeCategory[] Returns an array of BandeCategory objects
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
    public function findOneBySomeField($value): ?BandeCategory
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
