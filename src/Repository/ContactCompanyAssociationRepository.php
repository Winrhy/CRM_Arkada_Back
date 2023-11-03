<?php

namespace App\Repository;

use App\Entity\ContactCompanyAssociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactCompanyAssociation>
 *
 * @method ContactCompanyAssociation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactCompanyAssociation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactCompanyAssociation[]    findAll()
 * @method ContactCompanyAssociation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactCompanyAssociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactCompanyAssociation::class);
    }

//    /**
//     * @return ContactCompanyAssociation[] Returns an array of ContactCompanyAssociation objects
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

//    public function findOneBySomeField($value): ?ContactCompanyAssociation
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
