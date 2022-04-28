<?php

namespace App\Repository;

use App\Entity\GeneralConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GeneralConfiguration|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeneralConfiguration|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeneralConfiguration[]    findAll()
 * @method GeneralConfiguration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneralConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GeneralConfiguration::class);
    }

    public function findLast()
    {
        return $this->createQueryBuilder('q')
            ->orderBy('q.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return GeneralConfiguration[] Returns an array of GeneralConfiguration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GeneralConfiguration
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
