<?php

namespace App\Repository;

use App\Entity\BandePromo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BandePromo|null find($id, $lockMode = null, $lockVersion = null)
 * @method BandePromo|null findOneBy(array $criteria, array $orderBy = null)
 * @method BandePromo[]    findAll()
 * @method BandePromo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BandePromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BandePromo::class);
    }

    // /**
    //  * @return BandePromo[] Returns an array of BandePromo objects
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
            ->innerJoin('b.promos', 'p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?BandePromo
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
