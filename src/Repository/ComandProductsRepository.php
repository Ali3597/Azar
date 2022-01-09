<?php

namespace App\Repository;

use App\Entity\ComandProducts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ComandProducts|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComandProducts|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComandProducts[]    findAll()
 * @method ComandProducts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComandProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComandProducts::class);
    }


    // /**
    //  * @return ComandProducts[] Returns an array of ComandProducts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ComandProducts
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
