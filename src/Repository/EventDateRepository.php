<?php

namespace App\Repository;

use App\Entity\EventDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventDate[]    findAll()
 * @method EventDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventDate::class);
    }

    // /**
    //  * @return EventDate[] Returns an array of EventDate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventDate
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
