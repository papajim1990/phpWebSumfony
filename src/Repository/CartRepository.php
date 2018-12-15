<?php

namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CartRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function GetAllCartProducts($usr)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM cart WHERE idcutomer = :id ';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $usr);
        $stmt->execute();
        $resultset = array();
        foreach ($stmt->fetchAll() as $article) {
            $cart = new Cart();
            $cart->setId($article["id"]);
            $cart->setCustomer($article["idcutomer"]);
            $cart->setProduct($article["idproduct"]);
            $cart->setQuantity($article["quantity"]);


            array_push($resultset, $cart);
        }
        return $resultset;
        // returns an array of arrays (i.e. a raw data set)
    }
}
