<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
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
    public function findAllGreaterThanPrice($price): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM article p
        WHERE p.price LIKE :price
        ORDER BY p.price ASC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['price' => $price]);
        $resultset=array();
        foreach($stmt->fetchAll() as $article){
            $Artilce = new Article();
            $Artilce->setId($article["id"]);
            $Artilce->setName($article["name"]);
            $Artilce->setPrice($article["price"]);
            array_push($resultset, $Artilce);
        }
        // returns an array of arrays (i.e. a raw data set)
        return $resultset;
    }
}
