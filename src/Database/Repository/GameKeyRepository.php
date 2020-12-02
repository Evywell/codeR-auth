<?php

namespace App\Database\Repository;

use App\Database\Entity\GameKey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameKey|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameKey|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameKey[]    findAll()
 * @method GameKey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameKeyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameKey::class);
    }

    // /**
    //  * @return GameKey[] Returns an array of GameKey objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameKey
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
