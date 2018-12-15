<?php

namespace App\Repository;

use App\Entity\Layoutoptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class LayoutoptionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Layoutoptions::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('l')
            ->where('l.something = :value')->setParameter('value', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function GetAllOptions(){
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM layoutoptions ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultset=array();
        foreach($stmt->fetchAll() as $article){
            $options = new Layoutoptions();
            $options->setId($article["id"]);
            $options->setH1($article["h1"]);
            $options->setH4($article["h4"]);
            $options->setP($article["p"]);

            array_push($resultset, $options);
        }
        // returns an array of arrays (i.e. a raw data set)
        return $resultset;
    }
}
