<?php

namespace App\Repository;

use App\Entity\Imageurlsoptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ImageurlsoptionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Imageurlsoptions::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('i')
            ->where('i.something = :value')->setParameter('value', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function GetAllImagesOptions()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM imageurlsoptions';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultset = array();
        foreach ($stmt->fetchAll() as $article) {
            $options = new Imageurlsoptions();
            $options->setId($article["id"]);
            $options->setImageurl($article["imageurl"]);


            array_push($resultset, $options);
        }
        return $resultset;
        // returns an array of arrays (i.e. a raw data set)
    }
    public function DeleteImag($imageurl)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'Delete  FROM imageurlsoptions where imageurl like :imageurl ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(["imageurl"=>$imageurl]);

        // returns an array of arrays (i.e. a raw data set)
    }
    }
