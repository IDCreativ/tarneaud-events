<?php

namespace App\Repository;

use App\Entity\PollOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PollOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method PollOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method PollOption[]    findAll()
 * @method PollOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PollOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PollOption::class);
    }

    // /**
    //  * @return PollOption[] Returns an array of PollOption objects
    //  */
    public function findById($value): ?PollOption
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function countTotal($value)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
                SELECT COUNT(poll_option_id) as total
                FROM poll_vote as PV
                WHERE poll_option_id = :val
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('val' => $value));
        return $stmt->fetch();
    }

    // /**
    //  * @return PollOption[] Returns an array of PollOption objects
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
    public function findOneBySomeField($value): ?PollOption
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
