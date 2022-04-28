<?php

namespace App\Repository;

use App\Entity\ContestQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContestQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContestQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContestQuestion[]    findAll()
 * @method ContestQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContestQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContestQuestion::class);
    }

    // /**
    //  * @return ContestQuestion[] Returns an array of ContestQuestion objects
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
    public function findOneBySomeField($value): ?ContestQuestion
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
