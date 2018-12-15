<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields
    /**
     * @ORM\Column(type="integer")
     */
    private $idcutomer;
    /**
     * @ORM\Column(type="integer")
     */
    private $idproduct;
    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;
    public function getId()

    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getCustomer()
    {
        return $this->idcutomer;
    }

    public function setCustomer($idcutomer)
    {
        $this->idcutomer = $idcutomer;
    }
    public function getProduct()
    {
        return $this->idproduct;
    }

    public function setProduct($idproduct)
    {
        $this->idproduct = $idproduct;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
}
