<?php
/**
 * Created by PhpStorm.
 * User: Jolanta
 * Date: 15.03.2018
 * Time: 00:18
 */

namespace AppBundle\Controller;

use AppBundle\Form\AccountType;
use AppBundle\Form\UserPhotoType;
use AppBundle\Form\AdminPasswordType;
use AppBundle\Form\RegistrationType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/user/register", name="rejestracja")
     */
    public function registerAction(Request $request){
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setDateAdded(new \DateTime('now'));
            $user->setBlocked(0);
            $user->setPhoto('avatar.png');
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_panel');
        }

        return $this->render('user/register.html.twig', ['form'=>$form->createView()]);
    }
    /**
     * @Route("/user/dashboard", name="user_panel")
     */
    public function UserPanelAction(){
        $session = $this->get('session');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $session->set('user', 1);
        $session = $this->get('session');
        $session->set('logged', $user->getUsername());

        return $this->render('user/panel.html.twig', ['user_id'=>$user->getId(), 'blocked'=>$user->getBlocked()]);
    }
    /**
     * @Route("/user/delete/{userId}", name="user_delete")
     */
    public function deleteAccountAction($userId){
        $user = $this->get('app.repository.user')->findById($userId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user[0]);
        $em->flush();
        $session = $this->get('session');
        $session->clear();

        return $this->redirectToRoute('serwis');
    }
    /**
     * @Route("/user/account-settings", name="user_account")
     */
    public function UserAccountAction(Request $request) {
        $user = $this->loggedUser();

        $form_data = $this->createForm(AccountType::class, $user);
        $form_data->handleRequest($request);

        if ($form_data->isSubmitted()) {
            $user->setDateAdded(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        $form_password = $this->createForm(AdminPasswordType::class, $user);
        $form_password->handleRequest($request);

        if ($form_password->isSubmitted()) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        };

        $prev_photo = $user->getPhoto();
        $photo_form = $this->createForm(UserPhotoType::class, $user);
        $photo_form->handleRequest($request);

        if ($photo_form->isSubmitted() && $photo_form->isValid()) {
            if ($prev_photo && $prev_photo!='avatar.png') {
                unlink($this->getParameter('photos_user_directory').'/'.$prev_photo);
            }
            $photo = $user->getPhoto();
            $hashedPhoto= md5(uniqid()).'.'.$photo->guessExtension();
            $photo->move($this->getParameter('photos_user_directory'), $hashedPhoto);
            $user->setPhoto($hashedPhoto);
            $prev_photo = $user->getPhoto();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('user/account_settings.html.twig', ['form_data'=>$form_data->createView(),
            'form_password'=>$form_password->createView(), 'photo_form'=>$photo_form->createView(), 'user_photo'=>$prev_photo]);
    }

    /**
     * @Route("/admin/{userId}/page/{page}", name="admin_user_adverts")
     * @Route("/user/adverts/page/{page}", name="user_adverts")
     */
    public function UserAdvertsAction($userId = null, $page){

        if (!$this->loggedUserId() && !$userId) {
            return $this->render('user/noAccess.html.twig');
        }

        $userId = $this->loggedUserId() ? $this->loggedUserId() : $userId;
        $admin_entry = $userId ? 1 : 0;
        $adverts = $this->get('app.repository.adverts')->findUserPaginated($page, $userId);
        $page_number = ceil(count($this->get('app.repository.adverts')->findByUserId($userId))/8);


        return $this->render('user/adverts.html.twig', ['adverts'=>$adverts, 'user_id'=>$userId, 'page_number' => $page_number, 'admin_entry' => $admin_entry, 'userId'=>$userId]);
    }

    /**
     * @Route("/user/notifications", name="user_notifications")
     */
    public function notificationAction()
    {
        $notifications = $this->get('app.repository.notification')->userNotifications($this->loggedUserId());

        return $this->render('user/notifications.html.twig', ['notifications'=>$notifications]);
    }

    private function loggedUserId() {
        $username = $this->get('security.token_storage')->getToken()->getUsername();
        $user = $this->get('app.repository.user')->findBy(['username'=>$username]);
        if (empty($user)){
            return 0;
        } else {
            $user_id = $user[0]->getId();
            return $user_id;
        }
    }
    /**
     * Currently logged user
     *
     * @return int
     */
    private function loggedUser()
    {
        $securityToken = $this->get('security.token_storage')->getToken();

        $username = $securityToken ? $securityToken->getUsername(): '';

        if (!$username) {
            return 0;
        } else {
            $user = $this->get('app.repository.user')->findBy(['username' => $username]);
            return $user[0];
        }
    }

}