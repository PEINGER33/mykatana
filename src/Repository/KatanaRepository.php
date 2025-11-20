<?php

namespace App\Repository;

use App\Entity\Katana;
use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Katana>
 */
class KatanaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Katana::class);
    }
    
    public function findMemberKatanas(Member $member): array
    {
        return $this->createQueryBuilder('k')
        ->leftJoin('k.trousseau', 't')
        // jointure un peu barbare car Member, qui possède la relation vers Trousseau
        ->leftJoin('App\Entity\Member', 'm', 'WITH', 'm.trousseau = t')
        ->andWhere('m = :member')
        ->setParameter('member', $member)
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return Katana[] Returns an array of Katana objects
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

    //    public function findOneBySomeField($value): ?Katana
    //    {
    //        return $this->createQueryBuilder('k')
    //            ->andWhere('k.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
