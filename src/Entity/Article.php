<?php
/**
 * Created by PhpStorm.
 * User: user1
 * Date: 19/1/2018
 * Time: 3:13 πμ
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $price;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
         $this->id = $id;
    }

    public function getName()
{
    return $this->name;
}

    public function setName($name)
    {
        $this->name = $name;
    }
    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}