<?php

namespace App\Repository;

use App\Entity\ViewCounter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ViewCounter|null find($id, $lockMode = null, $lockVersion = null)
 * @method ViewCounter|null findOneBy(array $criteria, array $orderBy = null)
 * @method ViewCounter[]    findAll()
 * @method ViewCounter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ViewCounterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ViewCounter::class);
    }

    // /**
    //  * @return ViewCounter[] Returns an array of ViewCounter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ViewCounter
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByIpAndInstanceID($value, $ip, $type): ?ViewCounter
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.ip = :ip')
            ->setParameter('ip', $ip)
            ->andWhere('v.' . $type . ' = :value')
            ->setParameter('value', $value->getId())
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function CountAllview()
    {

        return $this->createQueryBuilder('v')
            ->select('count(v.id)')
            ->where("v.design = 1")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function deleteAll()
    {

        return $this->createQueryBuilder('v')
            ->delete()
            ->getQuery()
            ->execute();
    }
}
