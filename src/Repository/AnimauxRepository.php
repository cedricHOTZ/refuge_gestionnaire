<?php

namespace App\Repository;

use App\Entity\Animaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Animaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animaux[]    findAll()
 * @method Animaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animaux::class);
    }
    // public function findBestAds($animaux){
    //     return $this->createQueryBuilder('a')
    //     ->where('a.animaux = :animaux')
    //     ->setParameter('animaux', $animaux)
    //     ->orderBy("a.updated_at", 'DESC')
    //     ->setMaxResults(3);
    // }
    // /**
    //  * @return Animaux[] Returns an array of Animaux objects
    //  */
    
    public function findBestAds()
    {      
           $q = $this->createQueryBuilder('t')
           ->orderBy('t.created_at', 'DESC');         
            return $q->getQuery()->getResult();   
          }
    
          public function countAllHelp(){
              $queryBuilder = $this->createQueryBuilder('a');
              $queryBuilder->select('COUNT(a.id) as value');

              return $queryBuilder->getQuery()->getOneOrNullResult();
          }

    /*
    public function findOneBySomeField($value): ?Animaux
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
