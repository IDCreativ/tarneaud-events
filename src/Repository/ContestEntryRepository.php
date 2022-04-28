<?php

namespace App\Repository;

use App\Entity\ContestEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContestEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContestEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContestEntry[]    findAll()
 * @method ContestEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContestEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContestEntry::class);
    }

    // /**
    //  * @return ContestEntry[] Returns an array of ContestEntry objects
    //  */
    public function findByQuestion($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.contestQuestion = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByQuestionAndEmail($question, $email)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.contestQuestion = :question')
            ->setParameter('question', $question)
            ->andWhere('c.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public function findOneByEmail($value): ?ContestEntry
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.email = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
