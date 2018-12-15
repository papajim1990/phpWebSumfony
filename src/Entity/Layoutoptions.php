<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LayoutoptionsRepository")
 */
class Layoutoptions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
/**
* @ORM\Column(type="string", length=400)
*/
    private $h1;
    /**
     * @ORM\Column(type="string", length=400)
     */
    private $h4;
    /**


     * @ORM\Column(type="string", length=1000)
     */
    private $p;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getH1()
    {
        return $this->h1;
    }
    public function setH1($h1)
    {
        $this->h1 = $h1;
    }
    public function getH4()
    {
        return $this->h4;
    }
    public function setH4($h4)
    {
        $this->h4 = $h4;
    }
    public function getP()
    {
        return $this->p;
    }
    public function setP($p)
    {
        $this->p = $p;
    }
}
