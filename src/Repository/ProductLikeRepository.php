<?php

namespace App\Repository;

use App\Entity\ProductLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProductLikeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductLike::class);
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
    public function GetProductLikes($id){
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM product_like p
        WHERE p.idproduct = :id
        ORDER BY p.idproduct ASC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $resultset=array();
        foreach($stmt->fetchAll() as $article){
            $Artilce = new ProductLike();
            $Artilce->setId($article["id"]);
            $Artilce->setIdProduct($article["idproduct"]);
            $Artilce->setLikes($article["likes"]);

            array_push($resultset, $Artilce);
        }
        // returns an array of arrays (i.e. a raw data set)
        return $resultset;
    }
}
