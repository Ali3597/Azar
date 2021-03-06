<?php

namespace App\Repository;

use App\Entity\Command;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Command|null find($id, $lockMode = null, $lockVersion = null)
 * @method Command|null findOneBy(array $criteria, array $orderBy = null)
 * @method Command[]    findAll()
 * @method Command[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Command::class);
    }

    // /**
    //  * @return Command[] Returns an array of Command objects
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

    public function findUserCommands($userId)
    {

        $query = $this->createQueryBuilder('c');
        $query->leftJoin('c.user', 'user')
            ->Where('user.id = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('c.created_at', 'DESC');

        return   $query->getQuery()
            ->getResult();
    }

    public function findProductCommands($productId)
    {

        $query = $this->createQueryBuilder('c');
        $query->leftJoin('c.comandProducts', 'command')
        ->Where('command.products = :productId')
        ->setParameter('productId', $productId);
    

        return   $query->getQuery()
            ->getResult();
    }

    public function findAllVisibleQuery($search)
    {

        $query = $this->createQueryBuilder('c');
        if ($search->getQueryName()) {
            $query->leftJoin('c.user', 'user')
                ->andWhere('user.email LIKE :search')
                ->setParameter('search', '%' . $search->getQueryName() . '%');
        }

        return $query->getQuery();
    }

    public function findOneCommandByUSerAndCommandId($idCommand,$idUser)
    {

        $query = $this->createQueryBuilder('c')
            ->Where('c.id = :id')
            ->setParameter('id', $idCommand)
            ->andWhere('c.user = :idUser')
            ->setParameter('idUser', $idUser);
        

        return $query->getQuery()->getOneOrNullResult();
    }

    

    /*
    public function findOneBySomeField($value): ?Command
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
