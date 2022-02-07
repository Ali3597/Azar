<?php

namespace App\Repository;

use App\Entity\BandeArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BandeArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method BandeArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method BandeArticle[]    findAll()
 * @method BandeArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BandeArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BandeArticle::class);
    }

    // /**
    //  * @return BandeArticle[] Returns an array of BandeArticle objects
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
            ->innerJoin('b.articles', 'a')
            ->andWhere('a.id = :val')
            ->setParameter('val', $id)

            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?BandeArticle
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
