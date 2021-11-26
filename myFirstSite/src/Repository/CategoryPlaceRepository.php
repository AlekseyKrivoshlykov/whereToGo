<?php

namespace App\Repository;

use App\Entity\CategoryPlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryPlace[]    findAll()
 * @method CategoryPlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryPlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryPlace::class);
    }

    // /**
    //  * @return CategoryPlace[] Returns an array of CategoryPlace objects
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
    public function findOneBySomeField($value): ?CategoryPlace
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
