<?php

namespace App\Repository;

use App\Entity\SegmentContactAssociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SegmentContactAssociation>
 *
 * @method SegmentContactAssociation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SegmentContactAssociation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SegmentContactAssociation[]    findAll()
 * @method SegmentContactAssociation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SegmentContactAssociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SegmentContactAssociation::class);
    }

//    /**
//     * @return SegmentContactAssociation[] Returns an array of SegmentContactAssociation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SegmentContactAssociation
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
