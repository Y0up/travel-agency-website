<?php

namespace App\Repository;

use App\Entity\Agencies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Agencies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agencies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agencies[]    findAll()
 * @method Agencies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgenciesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agencies::class);
    }

    // /**
    //  * @return Agencies[] Returns an array of Agencies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Agencies
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
