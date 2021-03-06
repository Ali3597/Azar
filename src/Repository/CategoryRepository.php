<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findAllVisibleQuery($search)
    {
        $query = $this->createQueryBuilder('m');
        if ($search->getQueryName()) {
            $query->where('m.name LIKE :search')
                ->setParameter('search', '%' . $search->getQueryName() . '%');
        }
        return $query->getQuery();
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
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
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllHighCategories()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.category_parent is NULL')
            ->getQuery()
            ->getResult();
    }

    public function findHighCategoriesBeginWith(string $letter)
    {
        return $this->createQueryBuilder('c')
            ->Where('c.name LIKE :letter')
            ->setParameter('letter',  strtoupper($letter) . '%')
            ->orWhere('c.name LIKE :letter')
            ->setParameter('letter',  strtolower($letter) . '%')
            ->getQuery()
            ->getResult();
    }

    public function findAllLowCategoriesofCategoryParent($id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.category_parent = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }


    public function findHighCategoriesQueryWithSearch($search)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.category_parent is NULL');
        if ($search->getQueryName()) {
            $query->andWhere('c.name LIKE :search')
                ->setParameter('search', '%' . $search->getQueryName() . '%');
        }
        $query->orderBy('c.name', 'ASC');

        return $query->getQuery();
    }

    public function findLowCategoriesQueryWithSearch($search)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.category_parent is NOT NULL');
        if ($search->getQueryName()) {
            $query->andWhere('c.name LIKE :search')
                ->setParameter('search', '%' . $search->getQueryName() . '%');
        }
        $query->orderBy('c.name', 'ASC');

        return $query->getQuery();
    }

    public function findCategoriesChildrensQueryWithSearch($search, $id)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.category_parent = :id')
            ->setParameter('id', $id);
        if ($search->getQueryName()) {
            $query->andWhere('c.name LIKE :search')
                ->setParameter('search', '%' . $search->getQueryName() . '%');
        }
        $query->orderBy('c.name', 'ASC');

        return $query->getQuery();
    }
}
