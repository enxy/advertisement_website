<?php
/**
 * Created by PhpStorm.
 * User: Jolanta
 * Date: 17.03.2018
 * Time: 19:44
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route ("/user/login", name="login")
     */
    public function login(Request $request)
    {
        $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        $this->get('security.token_storage')->setToken(null);
        $session = $this->get('session');
        $session->clear();
        return $this->redirectToRoute('serwis');
    }
    /**
     * @Route ("/admin/login", name="admin_login")
     */
    public function AdminLoginAction(){
        $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/admin_login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}