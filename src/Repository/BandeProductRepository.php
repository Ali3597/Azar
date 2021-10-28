<?php

namespace App\Repository;

use App\Entity\BandeProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BandeProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method BandeProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method BandeProduct[]    findAll()
 * @method BandeProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BandeProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BandeProduct::class);
    }

    // /**
    //  * @return BandeProduct[] Returns an array of BandeProduct objects
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

    /*
    public function findOneBySomeField($value): ?BandeProduct
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
