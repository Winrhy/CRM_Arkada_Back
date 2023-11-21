<?php

namespace App\Repository;

use App\Entity\CtaStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CtaStats>
 *
 * @method CtaStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method CtaStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method CtaStats[]    findAll()
 * @method CtaStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CtaStatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CtaStats::class);
    }

//    /**
//     * @return CtaStats[] Returns an array of CtaStats objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CtaStats
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
