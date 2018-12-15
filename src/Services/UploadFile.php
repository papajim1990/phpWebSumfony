<?php
/**
 * Created by PhpStorm.
 * User: user1
 * Date: 20/1/2018
 * Time: 5:30 πμ
 */

namespace App\Services;


class UploadFile
{
    public function upload($files)
    {
        $filesnames=array();
        $filesnot=array();
        $filesfinal=array();
        $i=0;
        for ($i=0;$i<count($files["name"]);$i++) {
            $target_dir = "images/";
            $target_file = $target_dir . basename($files["name"][$i]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


// Check if file already exists
            if (file_exists($target_file)) {
                echo "uparxei: ".$target_file;
                array_push($filesnames, $target_file);
                $uploadOk = 0;
            }
// Check file size
            if ($files["size"][$i] > 500000) {
                $uploadOk = 1;
                array_push($filesnames, $target_file);
            }
// Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                ;
                $uploadOk = 0;
                array_push($filesnot, $target_file);
                echo "not image: ".$target_file;
            }
// Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {

                array_push($filesnot, $target_file);

// if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($files["tmp_name"][$i], $target_file)) {
                    echo "uploaded: ".$target_file;
                    array_push($filesnames, $target_file);
                    // actually executes the queries (i.e. the INSERT query)

                } else {
                    echo "malakia ".$target_file;
                    array_push($filesnot, $target_file);

                }
            };


            $i++;
        }
        array_push($filesfinal, $filesnot);
        array_push($filesfinal,$filesnames);
        return $filesfinal;
    }
}