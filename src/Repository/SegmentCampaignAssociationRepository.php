<?php

namespace App\Repository;

use App\Entity\SegmentCampaignAssociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SegmentCampaignAssociation>
 *
 * @method SegmentCampaignAssociation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SegmentCampaignAssociation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SegmentCampaignAssociation[]    findAll()
 * @method SegmentCampaignAssociation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SegmentCampaignAssociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SegmentCampaignAssociation::class);
    }

//    /**
//     * @return SegmentCampaignAssociation[] Returns an array of SegmentCampaignAssociation objects
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

//    public function findOneBySomeField($value): ?SegmentCampaignAssociation
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
