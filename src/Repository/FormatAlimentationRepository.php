<?php

namespace App\Repository;

use App\Entity\FormatAlimentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormatAlimentation>
 *
 * @method FormatAlimentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormatAlimentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormatAlimentation[]    findAll()
 * @method FormatAlimentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormatAlimentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormatAlimentation::class);
    }

    public function save(FormatAlimentation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FormatAlimentation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FormatAlimentation[] Returns an array of FormatAlimentation objects
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

//    public function findOneBySomeField($value): ?FormatAlimentation
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
