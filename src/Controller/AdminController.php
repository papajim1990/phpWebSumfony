<?php

namespace App\Controller;

use App\Entity\ProductLike;
use SpotifyWebAPI\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Article;
use App\Entity\Imageurlsoptions;
use App\Entity\Layoutoptions;
use App\Entity\Product;
use App\Services\UploadFile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Services\FileUploader;
use Symfony\Component\Filesystem\Filesystem;
use App\Entity\Media;

require_once '../vendor/autoload.php';

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $client_id = 'ee315a07f6af4a12a139a4fbed8224e9';
        $client_secret = 'd0830a31bd724c6b814cfa492df0d8f3';
        $redirect_uri="http://localhost:8000";
        $session = new Session(
            $client_id,
            $client_secret,
            $redirect_uri
        );

// Request a access token using the code from Spotify
        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();
        // replace this line with your own code!
        return $this->render('admin/admin.html.twig',array("result"=>$accessToken));
    }

    /**
     * @Route("/admin/layout")
     */
    public function layout()
    {

        $imageurl = $this->getDoctrine()
            ->getRepository(Imageurlsoptions::class)
            ->GetAllImagesOptions();
        $options = $this->getDoctrine()
            ->getRepository(Layoutoptions::class)
            ->GetAllOptions();
        return $this->render('admin/desing_admin_layout.html.twig', array("images" => $imageurl,"options"=>$options[0])
        );
    }

    /**
     * @Route("/newProduct")
     */
    public function CreateProducttwig()
    {
        return $this->render('admin/new_product.html.twig'

        );
    }

    /**
     * @Method("POST");
     * @Route("/DeleteFile")
     */
    public function deletefile()
    {
        $urlfile = $_POST["imgurl"];


        $fs = new Filesystem();
        $url = $this->getParameter("brochures_directory") . $urlfile;


        $filesystem = new Filesystem();
        $filesystem->remove($url);
        $this->getDoctrine()
            ->getRepository(Imageurlsoptions::class)
            ->DeleteImag(str_replace("/layout/", "", $urlfile));
        echo str_replace("/layout/", "", $urlfile);
        echo $url;
        return new Response('Ok: ');
    }

    /**
     * @Route("/admin/DesignLayout")
     * @Method({"POST"})
     */
    public function DesignLayout(FileUploader $fileUploader)
    {
        $filesnames = array();
        $em = $this->getDoctrine()->getManager();
        $options = new Layoutoptions();
        $options->setId(1);
        $options->setH1($_POST["history-wrapper-h1"]);
        $options->setH4($_POST["history-wrapper-h4"]);
        $options->setP($_POST["history-wrapper-p"]);
        $fs = new Filesystem();

        try {
            $fs->mkdir($this->getParameter("brochures_directory")."/layout");
        } catch (IOExceptionInterface $e) {
            echo "An error occurred while creating your directory at ".$e->getPath();
        }

        for ($i = 0; $i < count($_FILES["history-wrapper-images"]["name"]); $i++) {
            $images = new Media();

            $myfile = new UploadedFile($_FILES["history-wrapper-images"]["tmp_name"][$i], $_FILES["history-wrapper-images"]["name"][$i], $_FILES["history-wrapper-images"]["type"][$i], $_FILES["history-wrapper-images"]["size"][$i], $_FILES["history-wrapper-images"]["error"][$i]);
            $images->setFile($myfile);
            $fs->exists('/tmp/photos');
            $fileName = $images->upload($this->getParameter("brochures_directory")."/layout");

            array_push($filesnames, $fileName);

        }


        $em->merge($options);


        foreach ($filesnames as $imageurl) {
            echo "bhke vas: " . $imageurl;
            $images = new Imageurlsoptions();
            $images->setImageurl($imageurl);

            $em->persist($images);

        }
        $em->flush();
        return $this->render('admin/admin.html.twig'
        );


    }

    /**
     * @Route("/createProduct", name="product_new")
     * @Method({"POST"})
     */
    public function CreateProduct()
    {
        $em = $this->getDoctrine()->getManager();
        $product = new Product();
        $product->setName($_POST["name"]);
        $product->setPrice($_POST["price"]);
        $product->setTitle($_POST["title"]);
        $date = date('Y-m-d H:i:s');
        $product->setDate(\DateTime::createFromFormat('Y-m-d H:i:s', $date));
        $service = new UploadFile();
        $target_file = $service->upload($_FILES["fileToUpload"])[1];
        $product->setImages($target_file[0]);
        $product->setcontent($_POST["content"]);
        $em->persist($product);
        $em->flush();
        $em = $this->getDoctrine()->getManager();
        $productlike = new ProductLike();
        $productlike->setIdProduct($product->getId());
        $productlike->setLikes(0);
        $em->persist($productlike);
        $em->flush();

        return $this->render('admin/admin.html.twig', [
            'article' => $product,
        ]);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)


        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
