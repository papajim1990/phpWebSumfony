<?php
/**
 * Created by PhpStorm.
 * User: user1
 * Date: 19/1/2018
 * Time: 2:17 πμ
 */

namespace App\Controller {

    use App\Entity\Article;
    use App\Entity\Cart;
    use App\Entity\Imageurlsoptions;
    use App\Entity\Layoutoptions;
    use App\Entity\Product;
    use App\Entity\ProductLike;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Response;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use App\Services\UploadFile;
    use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

    class MyController extends Controller
    {
        /**
         * @Route("/")
         */
        public function Index()
        {

            $user = $this->getUser();
            if ($user) {
                echo $user->getEmail();
            }

            $options = $this->getDoctrine()
                ->getRepository(Layoutoptions::class)
                ->GetAllOptions();
            $product = $this->getDoctrine()
                ->getRepository(Product::class)
                ->GetAllProductsLimit();

            $images = $this->getDoctrine()
                ->getRepository(Imageurlsoptions::class)
                ->GetAllImagesOptions();
            
            return $this->render('lucky/number.html.twig', array("newArray" => array(
                'options' => $options, 'products' => $product, 'imagesoptions' => $images)
            ));

        }

        /**
         * @Route("/insertArticle")
         * @Method({"POST"})
         */
        public function CreateArticle()
        {
            $em = $this->getDoctrine()->getManager();

            $product = new Article();
            $product->setName($_POST["name"]);
            $product->setPrice($_POST["price"]);


            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($product);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
            return $this->render('lucky/number.html.twig'
            );
        }

        /**
         * @Route("/product/{slug}", name="product_show")
         */
        public function showAction($slug)
        {
            $product = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findAllGreaterThanPrice($slug);


            if ($product) {

                return $this->render('lucky/product_page.html.twig', [
                    'article' => $product[0],
                ]);


            } else {
                return new Response('No product: ');

            }

            // or render a template
            // in the template, print things with {{ product.name }}
            // return $this->render('product/show.html.twig', ['product' => $product]);
        }

        /**
         * @Route("/products_page")
         */
        public function ProductsPage()
        {
            $product = $this->getDoctrine()
                ->getRepository(Product::class)
                ->GetAllProducts();


            return $this->render('lucky/products_page.html.twig', array(
                'products' => $product,
            ));
        }

        /**
         * @Route("/timeline")
         */
        public function timeline()
        {
            $product = $this->getDoctrine()
                ->getRepository(Product::class)
                ->GetAllProducts();
            usort($product, function ($a, $b) {
                $ad = $a->getDate();
                $bd = $b->getDate();

                if ($ad == $bd) {
                    return 0;
                }

                return $ad > $bd ? -1 : 1;
            });
            return $this->render('lucky/timeline_products.html.twig', array(
                'products' => $product,
            ));
        }

        /**
         * @Route("/MoreProducts")
         * @Method("POST");
         */
        public function MoreProducts()
        {

            $product = $this->getDoctrine()
                ->getRepository(Product::class)
                ->GetAllProductsOfset($_POST["itemCount"]);
            $returnstring = "";
            foreach ($product as $pro) {
                $returnstring = $returnstring . "<div class=\"col-md-4 col-sm-4 col-xs-12 mix web\">
                    <div class=\"img home-portfolio-image\">
                        <img src=\"" . $pro->getImages() . "\" alt=\"Portfolio Item\">
                        <div class=\"overlay-thumb\">
                            <a href=\"javascript:void(0)\" class=\"like-product\">
                                <i class=\"ion-ios-heart-outline\"></i>
                                <span class=\"like-product\">Liked</span>
                                <span class=\"output\">250</span>
                            </a>
                            <div class=\"details\">
                                <span class=\"title\">" . $pro->getTitle() . "</span>
                                <span class=\"info\">" . $pro->getName() . "</span>
                            </div>
                            <span class=\"btnBefore\"></span>
                            <span class=\"btnAfter\"></span>
                            <a class=\"main-portfolio-link\" href=\"/product/" . $pro->getId() . "\"></a></a>
                        </div>
                    </div>
                </div>   ";
            }
            return new Response($returnstring);
        }

        /**
         * @Route("/about")
         */
        public function about()
        {

            return $this->render('lucky/about_us.html.twig'

            );
        }

        /**
         * @Route("/contact")
         */
        public function contact()
        {

            return $this->render('lucky/contact.html.twig'

            );
        }
        /**
         * @Method("POST");
         * @Route("/LikeProduct")
         */
        public function LikePro()
        {
            $em = $this->getDoctrine()->getManager();
        $product_id=$_POST["productid"];
            $product = $this->getDoctrine()
                ->getRepository(ProductLike::class)
                ->GetProductLikes($product_id);
            foreach ($product as $pro){
                $pro->setLikes($pro->getLikes()+1);
                $em->merge($pro);
            }
            $em->flush();
            return new Response("ok");
        }


        /**
         * @Route("/AddtoCart")
         */
        public function AddtoCart(){
            $usr=$this->get('security.token_storage')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();
            $cart = new Cart();
            $cart->setCustomer($usr->getId());
            $cart->setProduct($_POST["product_id"]);
            $cart->setQuantity(1);
            $em->persist($cart);
            $em->flush();
            return new Response("ok");

        }
        /**
         * @Route("/CheckOut")
         */
        public function CartLayout(){
            $usr=$this->get('security.token_storage')->getToken()->getUser()->getId();
            $em = $this->getDoctrine()->getRepository(Cart::class)->GetAllCartProducts($usr);
            $products =  array();

    foreach ($em as $result){
        $product = $this->getDoctrine()->getRepository(Product::class)->GetAllProductsById($result->getProduct())[0];

        array_push($products,$product);
    }
            return $this->render('lucky/Checkout.html.twig', array("results"=>$products));

        }
    }

}
