<?php

namespace App\Repository;

use App\Entity\FormStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormStats>
 *
 * @method FormStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormStats[]    findAll()
 * @method FormStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormStatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormStats::class);
    }

//    /**
//     * @return FormStats[] Returns an array of FormStats objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FormStats
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
