<?php

namespace App\Repository;

use App\Entity\Typebien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Typebien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typebien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typebien[]    findAll()
 * @method Typebien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypebienRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Typebien::class);
    }

//    /**
//     * @return Typebien[] Returns an array of Typebien objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Typebien
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
