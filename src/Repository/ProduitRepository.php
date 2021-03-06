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

    public function findProductsDependsOnSearch($search, $order = null)
    {


        $query = $this->createQueryBuilder('p')
            ->Where('p.afficher = true');
        $query->andWhere('p.name LIKE :search')
            ->setParameter('search', '%' . $search . '%');
        if ($order) {
            $query->orderBy("p.name", $order);
        }

        return   $query->getQuery()
            ->getResult();
    }

    public function findProductsDependsOnMarqueSlug($marqueSlug, $order = null)
    {


        $query = $this->createQueryBuilder('p')
            ->Where('p.afficher = true');
        $query->Join('p.marque', 'marqueJoin')

            ->andWhere('marqueJoin.slug = :marqueSlug')
            ->setParameter('marqueSlug', $marqueSlug);
        if ($order) {
            $query->orderBy("p.name", $order);
        }


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
    public function findProductsDependsOnCategoryIdWithSearch($categoryId, $search)
    {


        $query = $this->createQueryBuilder('p');

        $query
            ->andWhere('p.category = :categoryId')
            ->setParameter('categoryId', $categoryId);
        if ($search->getQueryName()) {
            $query->andWhere('p.name LIKE :search')
                ->setParameter('search', '%' . $search->getQueryName() . '%');
        }
        return   $query->getQuery();
    }

    public function findProductsDependsOnCategorySlug($categorySlug, $order = null)
    {


        $query = $this->createQueryBuilder('p')
            ->Where('p.afficher = true');
        $query->Join('p.category', 'categoryJoin')
            ->andWhere('categoryJoin.slug = :categorySlug')
            ->setParameter('categorySlug', $categorySlug);
        if ($order) {
            $query->orderBy("p.name", $order);
        }

        return   $query->getQuery()
            ->getResult();
    }
    public function findFourProductsDependsOnCategoryId($categoryId, $productId)
    {


        $query = $this->createQueryBuilder('p')
            ->Where('p.afficher = true');
        $query
            ->andWhere('p.category = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->andWhere('p.id != :productId')
            ->setParameter('productId', $productId)
            ->setMaxResults(4);


        return   $query->getQuery()
            ->getResult();
    }


    public function findProductsDependsOnParameters($categorySlug = null, $search = "none", $marqueSlug = null, $order = null)
    {
        $query = $this->createQueryBuilder('p')
            ->Where('p.afficher = true');
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
        if ($order) {
            $query->orderBy("p.name", $order);
        }
        return   $query->getQuery()
            ->getResult();
    }



    public function findUserWantingsWithSearch($userId, $search)
    {

        $query = $this->createQueryBuilder('p');
        $query->leftJoin('p.usersWanter', 'user')
            ->Where('user.id = :userId')
            ->setParameter('userId', $userId);
        if ($search->getQueryName()) {
            $query->andWhere('p.name LIKE :search')
                ->setParameter('search', '%' . $search->getQueryName() . '%');
        }


        return   $query->getQuery()
            ->getResult();
    }




    public function findProductsinOneCategory($id)
    {
        return $this->createQueryBuilder('p')
            ->Where('p.afficher = true')
            ->andWhere('p.category = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
