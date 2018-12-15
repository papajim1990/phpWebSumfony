<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductLikeRepository")
 */
class ProductLike
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
    private $idproduct;
    /**
     * @ORM\Column(type="integer")
     */
    private $likes;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    public function setIdProduct($idproduct)
    {
        $this->idproduct = $idproduct;
    }
    public function getIdProduct()
    {
        return $this->idproduct;
    }
    public function getLikes()
    {
        return $this->likes;
    }
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }
}
