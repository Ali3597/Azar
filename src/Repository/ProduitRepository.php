<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllVisibleQuery($search)
    {
        $query = $this->createQueryBuilder('p');
        if ($search->getQueryName()) {
            $query->where('p.name LIKE :search')
                ->setParameter('search', '%' . $search->getQueryName() . '%');
        }
        return $query->getQuery();
    }

    public function findProductsDependsOnSearch($search)
    {


        $query = $this->createQueryBuilder('p');

        $query->Where('p.name LIKE :search')
            ->setParameter('search', '%' . $search . '%');


        return   $query->getQuery()
            ->getResult();
    }

    public function findProductsDependsOnMarqueSlug($marqueSlug)
    {


        $query = $this->createQueryBuilder('p');

        $query->Join('p.marque', 'marqueJoin')
            ->andWhere('marqueJoin.slug = :marqueSlug')
            ->setParameter('marqueSlug', $marqueSlug);


        return   $query->getQuery()
            ->getResult();
    }
    public function findProductsDependsOnMarqueIdWithSearch($marqueId, $search)
    {


        $query = $this->createQueryBuilder('p');

        $query
            ->andWhere('p.marque = :marqueId')
            ->setParameter('marqueId', $marqueId);
        if ($search->getQueryName()) {
            $query->andWhere('p.name LIKE :search')
                ->setParameter('search', '%' . $search->getQueryName() . '%');
        }
        return   $query->getQuery();
    }

    public function findProductsDependsOnCategorySlug($categorySlug)
    {


        $query = $this->createQueryBuilder('p');

        $query->Join('p.category', 'categoryJoin')
            ->andWhere('categoryJoin.slug = :categorySlug')
            ->setParameter('categorySlug', $categorySlug);


        return   $query->getQuery()
            ->getResult();
    }

    public function findProductsDependsOnParameters($categorySlug = null, $search = "none", $marqueSlug = null)
    {


        $query = $this->createQueryBuilder('p');
        if ($search) {
            $query->andWhere('p.name LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }
        if ($categorySlug) {
            $query->Join('p.category', 'categoryJoin')
                ->andWhere('categoryJoin.slug = :categorySlug')
                ->setParameter('categorySlug', $categorySlug);
        }
        if ($marqueSlug != "none") {
            if ($marqueSlug) {

                $query->Join('p.marque', 'marqueJoin')
                    ->andWhere('marqueJoin.slug = :marqueSlug')
                    ->setParameter('marqueSlug', $marqueSlug);
            } else {


                $query->andWhere('p.marque is  NULL');
            }
        }
        return   $query->getQuery()
            ->getResult();
    }
    public function findProductsinOneCategory($id)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
