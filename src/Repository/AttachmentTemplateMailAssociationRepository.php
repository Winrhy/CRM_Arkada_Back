<?php

namespace App\Repository;

use App\Entity\AttachmentTemplateMailAssociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AttachmentTemplateMailAssociation>
 *
 * @method AttachmentTemplateMailAssociation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttachmentTemplateMailAssociation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttachmentTemplateMailAssociation[]    findAll()
 * @method AttachmentTemplateMailAssociation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttachmentTemplateMailAssociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttachmentTemplateMailAssociation::class);
    }

//    /**
//     * @return AttachmentTemplateMailAssociation[] Returns an array of AttachmentTemplateMailAssociation objects
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

//    public function findOneBySomeField($value): ?AttachmentTemplateMailAssociation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
