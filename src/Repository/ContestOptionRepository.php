<?php

namespace App\Repository;

use App\Entity\ContestOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContestOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContestOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContestOption[]    findAll()
 * @method ContestOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContestOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContestOption::class);
    }

    // /**
    //  * @return ContestOption[] Returns an array of ContestOption objects
    //  */

    public function findById($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?ContestOption
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
