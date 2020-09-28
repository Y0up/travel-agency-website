<?php

namespace App\Repository;

use App\Entity\Requ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Requ|null find($id, $lockMode = null, $lockVersion = null)
 * @method Requ|null findOneBy(array $criteria, array $orderBy = null)
 * @method Requ[]    findAll()
 * @method Requ[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Requ::class);
    }

    // /**
    //  * @return Requ[] Returns an array of Requ objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Requ
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
