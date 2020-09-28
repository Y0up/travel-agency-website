<?php

namespace App\Repository;

use App\Entity\Incl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Incl|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incl|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incl[]    findAll()
 * @method Incl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InclRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Incl::class);
    }

    // /**
    //  * @return Incl[] Returns an array of Incl objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Incl
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
