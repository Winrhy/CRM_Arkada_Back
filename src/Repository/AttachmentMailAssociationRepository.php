<?php

namespace App\Repository;

use App\Entity\AttachmentMailAssociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AttachmentMailAssociation>
 *
 * @method AttachmentMailAssociation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttachmentMailAssociation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttachmentMailAssociation[]    findAll()
 * @method AttachmentMailAssociation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttachmentMailAssociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttachmentMailAssociation::class);
    }

//    /**
//     * @return AttachmentMailAssociation[] Returns an array of AttachmentMailAssociation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AttachmentMailAssociation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
