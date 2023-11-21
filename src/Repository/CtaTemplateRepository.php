<?php

namespace App\Repository;

use App\Entity\CtaTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CtaTemplate>
 *
 * @method CtaTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method CtaTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method CtaTemplate[]    findAll()
 * @method CtaTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CtaTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CtaTemplate::class);
    }

//    /**
//     * @return CtaTemplate[] Returns an array of CtaTemplate objects
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

//    public function findOneBySomeField($value): ?CtaTemplate
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
