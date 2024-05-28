<?php

namespace App\Repository;

use App\Entity\DisqueSsd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DisqueSsd>
 *
 * @method DisqueSsd|null find($id, $lockMode = null, $lockVersion = null)
 * @method DisqueSsd|null findOneBy(array $criteria, array $orderBy = null)
 * @method DisqueSsd[]    findAll()
 * @method DisqueSsd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisqueSsdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DisqueSsd::class);
    }

    public function save(DisqueSsd $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DisqueSsd $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DisqueSsd[] Returns an array of DisqueSsd objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DisqueSsd
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
