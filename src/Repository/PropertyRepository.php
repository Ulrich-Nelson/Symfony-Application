<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }
    
    
    /**
     * findAllVisible recherche tous les biens non vendus.
     *
     * @return Property[]
     */
    public function findAllVisible(): array
    {
        return$this->findAllVsisibleQuery()
            ->getQuery()
            ->getResult();
    }

    /**
     * findAllVisible recherche les derniers biens
     *
     * @return Property[]
     * 
     */
    public function findLatest(): array
    {
        return $this->findAllVsisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

        
    /**
     * findAllVsisibleQuery pour factoriser le code
     *
     * @return QueryBuilder
     */
    private function findAllVsisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    } 












    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
