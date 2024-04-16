<?php

namespace App\Repository;

use App\Entity\Jobber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Jobber>
 *
 * @method Jobber|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jobber|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jobber[]    findAll()
 * @method Jobber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jobber::class);
    }

    //    /**
    //     * @return Jobber[] Returns an array of Jobber objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('j.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Jobber
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
