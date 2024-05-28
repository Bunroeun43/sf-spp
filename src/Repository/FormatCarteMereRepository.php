<?php

namespace App\Repository;

use App\Entity\FormatCarteMere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormatCarteMere>
 *
 * @method FormatCarteMere|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormatCarteMere|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormatCarteMere[]    findAll()
 * @method FormatCarteMere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormatCarteMereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormatCarteMere::class);
    }

    public function save(FormatCarteMere $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FormatCarteMere $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FormatCarteMere[] Returns an array of FormatCarteMere objects
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

//    public function findOneBySomeField($value): ?FormatCarteMere
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
