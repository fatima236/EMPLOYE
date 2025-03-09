<?php

namespace App\Repository;

use App\Entity\Artisan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Artisan>
 */
class ArtisanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artisan::class);
    }
// src/Repository/ArtisanRepository.php

public function findAllQuery()
{
    return $this->createQueryBuilder('a')
        ->orderBy('a.id', 'ASC')
        ->getQuery();
}


// Méthode pour filtrer par nom complet
public function findByFullNameQuery(string $fullName): QueryBuilder
{
    return $this->createQueryBuilder('a')
        ->where('a.fullName LIKE :fullName')
        ->setParameter('fullName', '%'.$fullName.'%')
        ->orderBy('a.id', 'ASC');
}

    //    /**
    //     * @return Artisan[] Returns an array of Artisan objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Artisan
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
