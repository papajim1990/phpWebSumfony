<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class Media
{

    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    // add your own fields
    public function upload($pathio)
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        $fileName = md5(uniqid()).'.'.$this->getFile()->guessExtension();
        // move takes the target directory and target filename as params
        $this->getFile()->move(
            $pathio,
            $fileName
        );

        // set the path property to the filename where you've saved the file
        $this->filename = $this->getFile()->getClientOriginalName();
    return $fileName;
        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }
}
