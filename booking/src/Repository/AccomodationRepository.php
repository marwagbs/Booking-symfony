<?php

namespace App\Repository;

use App\Entity\Accomodation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Accomodation>
 *
 * @method Accomodation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accomodation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accomodation[]    findAll()
 * @method Accomodation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccomodationRepository extends ServiceEntityRepository
{    
    public function __construct(ManagerRegistry $registry)
    {   
        parent::__construct($registry, Accomodation::class);
    }

    public function save(Accomodation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Accomodation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Accomodation[] Returns an array of Accomodation objects
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

//    public function findOneBySomeField($value): ?Accomodation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function search($city,$people, $dateA, $dateB): array
{   $city=strtolower($city);
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT ville_nom_simple, ville_latitude_deg, ville_longitude_deg 
            FROM spec_villes_france_free
            WHERE :city =ville_nom_simple';
           
    $request = $conn->prepare($sql);
    $resultSet  = $request->executeQuery(['city' => $city]);
    $city = $resultSet->fetchAssociative();
    
    $qbDate = $this-> createQueryBuilder("a2")
            ->innerJoin("a2.bookings", "bo")
            ->where("bo.startDateAt < :dateA")
            ->AndWhere("bo.endDateAt > :dateB");


    $qb =$this->createQueryBuilder('a')
      
        ->join('a.room','r')
        ->join('r.roomBeds','rb')
        ->join('rb.bed','b')
        ->groupBy("a")  
        ->having("SUM(b.size * rb.quantity) >= :people")
        ->setParameter("people",$people);
        
        
    $qb->addSelect("ACOS(SIN(PI()*a.latitude/180.0)*SIN(PI()*:lat2/180.0)+COS(PI()*a.latitude/180.0)*COS(PI()*:lat2/180.0)*COS(PI()*:lon2/180.0-PI()*a.longitude/180.0))*6371 AS dist")
        ->setParameter(":lat2", $city["ville_latitude_deg"])
        ->setParameter(":lon2", $city["ville_longitude_deg"])
        ->orderBy("dist") 
    ;
   
    //DATE
    if ($dateA && $dateB) {
        //requête imbriquée : ON EXCLUT LES LOGEMENTS NON DISPONIBLES -> c'est équivalent à utiliser where et set parameter
        $qb->andWhere($qb->expr()->notIn('a.id', $qbDate->getDQL()))
            ->setParameter("dateA", $dateA)
            ->setParameter("dateB", $dateB);
    }
    
   return $qb->getQuery()
    ->getResult();
}
}
// SELECT accomodation.title, SUM(room_bed.quantity * bed.size)
// FROM accomodation
// INNER JOIN room ON accomodation.id = room.accomodation_id
// INNER JOIN room_bed ON room.id = room_bed.room_id
// INNER JOIN bed ON room_bed.bed_id = bed.id
// WHERE accomodation.city="Trignac" 
// GROUP BY accomodation.title