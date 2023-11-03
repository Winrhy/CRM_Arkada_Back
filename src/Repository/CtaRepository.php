<?php

namespace App\Repository;

use App\Entity\Cta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cta>
 *
 * @method Cta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cta[]    findAll()
 * @method Cta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CtaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cta::class);
    }

//    /**
//     * @return Cta[] Returns an array of Cta objects
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

//    public function findOneBySomeField($value): ?Cta
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
