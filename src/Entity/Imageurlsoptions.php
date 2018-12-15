<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageurlsoptionsRepository")
 */
class Imageurlsoptions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     *@Assert\Image();
     * @ORM\Column(type="string", length=100)
     */
    private $imageurl;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getImageurl()
    {
        return $this->imageurl;
    }
    public function setImageurl($imageurl)
    {
        $this->imageurl = $imageurl;
    }
}
