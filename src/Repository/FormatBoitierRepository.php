<?php

namespace App\Repository;

use App\Entity\FormatBoitier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormatBoitier>
 *
 * @method FormatBoitier|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormatBoitier|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormatBoitier[]    findAll()
 * @method FormatBoitier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormatBoitierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormatBoitier::class);
    }

    public function save(FormatBoitier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FormatBoitier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FormatBoitier[] Returns an array of FormatBoitier objects
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

//    public function findOneBySomeField($value): ?FormatBoitier
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
