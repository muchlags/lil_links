<?php

namespace App\Repository;

use App\Entity\LinkPairs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LinkPairs>
 *
 * @method LinkPairs|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkPairs|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkPairs[]    findAll()
 * @method LinkPairs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkPairsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkPairs::class);
    }

//    /**
//     * @return LinkPairs[] Returns an array of LinkPairs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LinkPairs
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
