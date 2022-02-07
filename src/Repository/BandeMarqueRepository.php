<?php

namespace App\Repository;

use App\Entity\BandeMarque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BandeMarque|null find($id, $lockMode = null, $lockVersion = null)
 * @method BandeMarque|null findOneBy(array $criteria, array $orderBy = null)
 * @method BandeMarque[]    findAll()
 * @method BandeMarque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BandeMarqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BandeMarque::class);
    }

    // /**
    //  * @return BandeMarque[] Returns an array of BandeMarque objects
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
            ->innerJoin('b.marques', 'm')
            ->andWhere('m.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?BandeMarque
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
