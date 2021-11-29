<?php

namespace App\Repository;

use App\Entity\CategoryPlace;
use App\Repository\CategoryPlaceRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryPlace[]    findAll()
 * @method CategoryPlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryPlaceRepository extends ServiceEntityRepository implements CategoryPlaceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryPlace::class);
    }
 

    public function findCategory ($id)
    {
        $result = $this->createQueryBuilder('category_place')
            ->select('category_place.en_title')
            // ->join('place', 'p')
            ->where('category_place.id = :id') 
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
            
        return $result;
    }

}

