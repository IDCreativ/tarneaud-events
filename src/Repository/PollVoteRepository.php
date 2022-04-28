<?php

namespace App\Repository;

use App\Entity\PollVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PollVote|null find($id, $lockMode = null, $lockVersion = null)
 * @method PollVote|null findOneBy(array $criteria, array $orderBy = null)
 * @method PollVote[]    findAll()
 * @method PollVote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PollVoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PollVote::class);
    }

    public function countVoteForPollAndOption($poll, $option)
    {
        return $this->createQueryBuilder('q')
            ->select('COUNT(DISTINCT q.poll)')
            ->andWhere('q.poll = :poll')
            ->andWhere('q.pollOption = :option')
            ->setParameter('poll', $poll)
            ->setParameter('option', $option)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }

    public function findByUserAndPoll($user, $poll)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.poll = :poll')
            ->andWhere('q.user = :user')
            ->setParameter('poll', $poll)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }

    public function findById($value): ?PollVote
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByOption($value)
    {
        return $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->andWhere('p.pollOption = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByPoll($value)
    {
        return $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->andWhere('p.poll = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return PollVote[] Returns an array of PollVote objects
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
    public function findOneBySomeField($value): ?PollVote
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
