<?php

namespace App\Repository;

use App\Entity\CtaClicks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CtaClicks>
 *
 * @method CtaClicks|null find($id, $lockMode = null, $lockVersion = null)
 * @method CtaClicks|null findOneBy(array $criteria, array $orderBy = null)
 * @method CtaClicks[]    findAll()
 * @method CtaClicks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CtaClicksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CtaClicks::class);
    }

//    /**
//     * @return CtaClicks[] Returns an array of CtaClicks objects
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

//    public function findOneBySomeField($value): ?CtaClicks
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
