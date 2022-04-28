<?php

namespace App\Repository;

use App\Entity\Module;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Module|null find($id, $lockMode = null, $lockVersion = null)
 * @method Module|null findOneBy(array $criteria, array $orderBy = null)
 * @method Module[]    findAll()
 * @method Module[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Module::class);
    }

    // /**
    //  * @return Module[] Returns an array of Module objects
    //  */
    public function findBySlug($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.slug = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Module
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
