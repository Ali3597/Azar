<?php

namespace App\Repository;

use App\Entity\Bande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bande[]    findAll()
 * @method Bande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bande::class);
    }

    // /**
    //  * @return Bande[] Returns an array of Bande objects
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
    public function findOneBySomeField($value): ?Bande
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllBandesByPosition()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.position', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneBandeByPosition($position)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.position = :val')
            ->setParameter('val', $position)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
