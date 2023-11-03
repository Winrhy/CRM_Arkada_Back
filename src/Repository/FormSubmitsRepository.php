<?php

namespace App\Repository;

use App\Entity\FormSubmits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormSubmits>
 *
 * @method FormSubmits|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormSubmits|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormSubmits[]    findAll()
 * @method FormSubmits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormSubmitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormSubmits::class);
    }

//    /**
//     * @return FormSubmits[] Returns an array of FormSubmits objects
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

//    public function findOneBySomeField($value): ?FormSubmits
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
