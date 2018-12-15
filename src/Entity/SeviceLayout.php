<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeviceLayoutRepository")
 */
class SeviceLayout
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields
    /**
     * @ORM\Column(type="string", length=400)
     */
    private $h4;
    /**


     * @ORM\Column(type="string", length=1000)
     */
    private $p;
    /**


     * @ORM\Column(type="string", length=1000)
     */
    private $icon;
}
