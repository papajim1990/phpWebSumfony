<?php
/**
 * Created by PhpStorm.
 * User: user1
 * Date: 22/1/2018
 * Time: 4:23 πμ
 */

namespace App\Controller;

use App\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
class SecurityController extends Controller
{
    /**
     *@Route("/register" , name="registeruser")
     */
    public function registerpage(Request $request, AuthenticationUtils $authUtils){
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('security/register.html.twig',array("last_username"=>$lastUsername,"error"=>null));
    }
    /**
     * @Method("POST");
     * @Route("/registerUser", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder,AuthenticationUtils $authUtils)
    {
        if ($_POST["password"] == $_POST["repeated_password"]) {
            $lastUsername = $authUtils->getLastUsername();
        // 1) build the form
        $user = new User();
        $user->setUsername($_POST["username"]);
        $user->setEmail($_POST["email"]);

        // 3) Encode the password (you could also do this via Doctrine listener)
        $password = $passwordEncoder->encodePassword($user, $_POST["password"]);
        $user->setPassword($password);

        // 4) save the User!
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }
catch(UniqueConstraintViolationException $e){
    return $this->render('security/register.html.twig',array("last_username"=>$lastUsername,"error"=>"You have already an acount for the email provided!"));

}

        // ... do any other work - like sending them an email, etc
        // maybe set a "flash" success message for the user

        return $this->render('security/login.html.twig');
    }else
{
return $this->render('security/register.html.twig',array("error"=>"There was a problem with the information provided try again!"));
}

    }
    public function authenticate(){

    }
    /**
     * @Route("/login", name="login")
     */

    public function loginAction(Request $request)
    {
        $user = $this->getUser();
        if ($user) {
            return $this->redirect("/admin");
        }
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }



}