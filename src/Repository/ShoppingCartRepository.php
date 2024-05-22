<?php

namespace App\Repository;

use App\Entity\ShoppingCart;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShoppingCart>
 */
class ShoppingCartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingCart::class);
    }

    public function removeProduct(int $id, User $user)
    {
        $this->getEntityManager()->createQuery('DELETE FROM App\Entity\ShoppingCart shp WHERE shp.product = :productId AND shp.user = :user')
            ->setParameter('productId', $id)
            ->setParameter('user', $user)
            ->execute();
    }

    //    /**
    //     * @return ShoppingCart[] Returns an array of ShoppingCart objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ShoppingCart
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
