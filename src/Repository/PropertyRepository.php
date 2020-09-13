<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Property;
use App\Entity\PropertySearch;
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
     * findAllVsisibleQuery
     * findAllVisibleQuery
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if ($search->getMaxPrice()) {
            $query = $query
                ->andwhere('p.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }
        if ($search->getMinSurface()) {
            $query = $query
                ->andwhere('p.surface >= :minsurface')
                ->setParameter('minsurface', $search->getMinSurface());
        }//condition pour ce qui est du calcul de la longitude et la latitude
        if ($search->getLat() && $search->getLng() && $search->getDistance() ) {
            $query = $query
                ->select('p')
                ->andWhere('(6353 * 2 * ASIN(SQRT( POWER(SIN((p.lat - :lat) *  pi()/180 / 2), 2) +COS(p.lat * pi()/180) * COS(:lat * pi()/180) * POWER(SIN((p.lng - :lng) * pi()/180 / 2), 2) ))) <= :distance')
                ->setParameter('lng', $search->getLng())
                ->setParameter('lat', $search->getLat())
                ->setParameter('distance', $search->getDistance());
        }
        

        //permet de récupérer un bien en fonction de l'option demandée.
        if ($search->getOptions()->count() > 0) {
            $k = 0;
            foreach ($search->getOptions() as $option) {
                $k++;
            $query = $query
                ->andwhere(":option$k MEMBER OF p.options")
                ->setParameter("option$k", $option);


            }
        }
           return $query->getQuery();
    }

    /**
     * findAllVisible recherche les derniers biens (publier les 04 derniers biens)
     *
     * @return Property[]
     * 
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

        
    /**
     * findAllVsisibleQuery pour factoriser le code (récupère tous les biens dont le solde est à false)
     *
     * @return QueryBuilder
     */
    private function findVisibleQuery(): QueryBuilder
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
