<?php

namespace App\Repository;

use App\Entity\Katanakake;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Katanakake>
 */
class KatanakakeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Katanakake::class);
    }

    //    /**
    //     * @return Katanakake[] Returns an array of Katanakake objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('k')
    //            ->andWhere('k.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('k.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Katanakake
    //    {
    //        return $this->createQueryBuilder('k')
    //            ->andWhere('k.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
