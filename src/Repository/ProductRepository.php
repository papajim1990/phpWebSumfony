<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use \PDO;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findAllGreaterThanPrice($id){
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM product p
        WHERE p.id = :id
        ORDER BY p.id ASC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $resultset=array();
        foreach($stmt->fetchAll() as $article){
            $Artilce = new Product();
            $Artilce->setId($article["id"]);
            $Artilce->setName($article["name"]);
            $Artilce->setPrice($article["price"]);
            $Artilce->setImages($article["images"]);
            $Artilce->setTitle($article["title"]);
            $Artilce->setcontent($article["content"]);
            $Artilce->setDate($article["date"]);
            array_push($resultset, $Artilce);
        }
        // returns an array of arrays (i.e. a raw data set)
        return $resultset;
    }
    public function GetAllProducts(){
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM product p
        
        ORDER BY p.id ASC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultset=array();
        foreach($stmt->fetchAll() as $article){
            $Artilce = new Product();
            $Artilce->setId($article["id"]);
            $Artilce->setName($article["name"]);
            $Artilce->setPrice($article["price"]);
            $Artilce->setImages($article["images"]);
            $Artilce->setTitle($article["title"]);
            $Artilce->setcontent($article["content"]);
            $Artilce->setDate($article["date"]);
            array_push($resultset, $Artilce);
        }
        // returns an array of arrays (i.e. a raw data set)
        return $resultset;
    }
    public function GetAllProductsById($id){
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM product p
        WHERE id = :id
        ORDER BY p.id ASC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $resultset=array();
        foreach($stmt->fetchAll() as $article){
            $Artilce = new Product();
            $Artilce->setId($article["id"]);
            $Artilce->setName($article["name"]);
            $Artilce->setPrice($article["price"]);
            $Artilce->setImages($article["images"]);
            $Artilce->setTitle($article["title"]);
            $Artilce->setcontent($article["content"]);
            $Artilce->setDate($article["date"]);
            array_push($resultset, $Artilce);
        }
        // returns an array of arrays (i.e. a raw data set)
        return $resultset;
    }
    public function GetAllProductsLimit(){
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM product 
        LIMIT :limit
        
        ';
        $limit=6;
        $offsetparam=intval($limit);
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":limit",$offsetparam,PDO::PARAM_INT);

        $stmt->execute();
        $resultset=array();
        foreach($stmt->fetchAll() as $article){
            $Artilce = new Product();
            $Artilce->setId($article["id"]);
            $Artilce->setName($article["name"]);
            $Artilce->setPrice($article["price"]);
            $Artilce->setImages($article["images"]);
            $Artilce->setTitle($article["title"]);
            $Artilce->setcontent($article["content"]);
            $Artilce->setDate($article["date"]);
            array_push($resultset, $Artilce);
        }
        // returns an array of arrays (i.e. a raw data set)
        return $resultset;
    }
    public function GetAllProductsOfset($offset){
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM product 
        LIMIT :limit,:offset
        
        ';
        $limit=4;
        $offsetparam=intval($offset);
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":offset",$offsetparam,PDO::PARAM_INT);
        $stmt->bindParam(":limit",$limit,PDO::PARAM_INT);

        $stmt->execute();
        $resultset=array();
        foreach($stmt->fetchAll() as $article){
            $Artilce = new Product();
            $Artilce->setId($article["id"]);
            $Artilce->setName($article["name"]);
            $Artilce->setPrice($article["price"]);
            $Artilce->setImages($article["images"]);
            $Artilce->setTitle($article["title"]);
            $Artilce->setcontent($article["content"]);
            $Artilce->setDate($article["date"]);
            array_push($resultset, $Artilce);
        }
        // returns an array of arrays (i.e. a raw data set)
        return $resultset;
    }
}
