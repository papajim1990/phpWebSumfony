<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AboutObjectRepository")
 */
class AboutObject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**

     * @ORM\Column(type="string")
     */
    private $aboutinfo;
    // add your own fields
}
