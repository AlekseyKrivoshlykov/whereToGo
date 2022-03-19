<?php

namespace App\Repository;

use App\Entity\Place;
use App\Entity\CategoryPlace;
use App\Repository\PlaceRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Place|null find($id, $lockMode = null, $lockVersion = null)
 * @method Place|null findOneBy(array $criteria, array $orderBy = null)
 * @method Place[]    findAll()
 * @method Place[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceRepository extends ServiceEntityRepository implements PlaceRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);

    }

    public function findQuery (string $value): array
    {
        $result = $this->createQueryBuilder('place')
            ->select('place.title', 'place.id', '(place.category_place)')
            ->where('place.title LIKE :value') 
            ->setParameter('value', '%'. $value . '%')
            ->getQuery()
            ->getArrayResult();

        return $result;
    }
}




