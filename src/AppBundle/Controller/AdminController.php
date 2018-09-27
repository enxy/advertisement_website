<?php
/**
 * Created by PhpStorm.
 * User: Jolanta
 * Date: 21.03.2018
 * Time: 08:48
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use Ivory\CKEditorBundle\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Admin;
use AppBundle\Form\RegistrationType;
use AppBundle\Form\AdminDetailsType;
use AppBundle\Form\AdminPasswordType;
use AppBundle\Form\PhotoType;
use AppBundle\Form\EditorType;

class AdminController extends Controller
{
    /**
     * @Route("/admin/panel", name="admin_panel")
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $session = $this->get('session');
        $session->set('logged', $user->getUsername());
        $session->set('admin', 1);

        return $this->render('admin/panel.html.twig');
    }
    /**
     * @Route("/admin/serwis/users", name="admin_users")
     */
    public function usersAction(){

        $users = $this->get('app.repository.user')->findAll();

        return $this->render('admin/users.html.twig', ['users'=>$users, 'admin_id'=>$this->loggedAdmin()]);
    }
    /**
     * @Route("/admin/delete/{adminId}", name="admin_delete")
     */
    public function deleteAdminAction($adminId){

        $admin = $this->get('app.repository.admin')->findById($adminId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($admin[0]);
        $em->flush();
        $session = $this->get('session');
        $session->clear();

        return $this->redirectToRoute('serwis');
    }
    /**
     * @Route("/admin/serwis/admins", name="admins")
     */
    public function adminsAction(Request $request){

        $admins = $this->get('app.repository.admin')->findAll();
        $username = $this->get('security.token_storage')->getToken()->getUsername();
        //$em = $this->getDoctrine()->getManager();

        $admin = new Admin();
        $add_form = $this->createForm(RegistrationType::class, $admin);
        $add_form->handleRequest($request);

        if ($add_form->isSubmitted() && $add_form->isValid()) {
            $password = $this->get('security.password_encoder')->encodePassword($admin, $admin->getPassword());
            $admin->setPassword($password);
            $admin->setPhoto('avatar.png');
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
            return $this->redirectToRoute('admins');
        }

        $current_admin = $this->get('app.repository.admin')->findBy(['username'=>$username])[0];
        $edit_form = $this->createForm(AdminDetailsType::class, $current_admin);
        $edit_form->handleRequest($request);
        if ($edit_form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($current_admin);
            $em->flush();
            return $this->redirectToRoute('admins');
        }

        $password_form = $this->createForm(AdminPasswordType::class, $current_admin);
        $password_form->handleRequest($request);
        if ($password_form->isSubmitted()) {
            $password = $this->get('security.password_encoder')->encodePassword($current_admin, $current_admin->getPassword());
            $current_admin->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($current_admin);
            $em->flush();
        }
        $prev_photo = $current_admin->getPhoto();
        $photo_form = $this->createForm(PhotoType::class, $current_admin);
        $photo_form->handleRequest($request);

        if ($photo_form->isSubmitted() && $photo_form->isValid()) {
            if ($prev_photo && $prev_photo != 'avatar.png') {
                unlink($this->getParameter('photos_admin_directory').'/'.$prev_photo);
            }
            $photo = $current_admin->getPhoto();
            $hashedPhoto= md5(uniqid()).'.'.$photo->guessExtension();
            $photo->move($this->getParameter('photos_admin_directory'), $hashedPhoto);
            $current_admin->setPhoto($hashedPhoto);
            $em = $this->getDoctrine()->getManager();
            $em->persist($current_admin);
            $em->flush();
        }
        return $this->render('admin/admins.html.twig', ['admins'=>$admins, 'add_form'=>$add_form->createView(), 'edit_form'=>$edit_form->createView(), 'username'=>$username,
                                'current_admin'=>$current_admin, 'password_form'=>$password_form->createView(), 'photo_form'=>$photo_form->createView()]);
    }
    /**
     * @Route("/admin/serwis/articels", name="admin_articles")
     */
    public function ArticlesAction(Request $request){
        $article1 = $this->render('articles/article1.html.twig');
        $form = $this->createForm(EditorType::class, $article1);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            var_dump($form->getData());
        }

        return $this->render('admin/articles.html.twig', ['form'=>$form->createView(), 'data'=>$article1]);
    }
    /**
     * @Route("/admin/block/user", name="block_user")
     */
    public function blockUserAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $flashbag = $this->get('session')->getFlashBag();

        try {
            $admin_id = $request->request->get('admin_id');
            $admin = $this->get('app.repository.admin')->findBy(['id' => $admin_id]);
            $user_id = $request->request->get('user_id');
            $user = $this->get('app.repository.user')->findBy(['id' => $user_id]);

            $notification = new Notification();
            $notification->setDate(new \DateTime('now'));
            $notification->setAdmin($admin[0]);
            $notification->setTitle($request->request->get('title'));
            $notification->setUser($user[0]);

            if ($user[0]->getBlocked()) {
                $user[0]->setBlocked(0);
                $notification->setDescription('Konto użytkownika zostało odblokowane');
            } else {
                $user[0]->setBlocked(1);
                $notification->setDescription($request->request->get('description'));
            }
            $em->persist($notification);
            $em->persist($user[0]);
            $em->flush();

        } catch(Exception $e) {
            $flashbag->add("error", "Wystąpił błąd: " . $e->getMessage());
        }

        return $this->redirectToRoute('admin_users');
    }

    /**
     * @Route("/admin/block/{userId}/advert/{advert}", name="block_advert")
     */
    public function blockAdvertAction(Request $request, $userId, $advert) {
        $em = $this->getDoctrine()->getManager();
        $flashbag = $this->get('session')->getFlashBag();

        try {
            $advert = $this->get('app.repository.adverts')->findBy(['id' => $advert]);
            $advert = $advert[0];
            $admin_id = $this->loggedAdmin();
            $admin = $this->get('app.repository.admin')->findBy(['id' => $admin_id]);
            $notification = new Notification();
            $notification->setDate(new \DateTime('now'));
            $notification->setAdmin($admin[0]);
            $notification->setUser($advert->getUserId());

            if ($advert->getBlocked()) {
                $advert->setBlocked(0);
                $notification->setTitle('Blokada ogłoszenia');
                $notification->setDescription('Ogłoszenie zostało odblokowane.');
            } else {
                $advert->setBlocked(1);
                $notification->setTitle('Odblokowanie ogłoszenia');
                $notification->setDescription('Ogłoszenie zostało zablokowane z powodu nieprawidłowej treści.');
            }
            $em->persist($advert);
            $em->persist($notification);
            $em->flush();
        } catch(Exception $e) {
            $flashbag->add("error", "Wystąpił błąd: " . $e->getMessage());
        }

        return $this->redirectToRoute('admin_user_adverts', ['userId'=> $userId,'page'=>1]);
    }
    /**
     * @Route("/admin/notifications", name="admin_notifications")
     */
    public function notificationAction()
    {
        $notifications = $this->get('app.repository.notification')->notificationsSorted();

        return $this->render('admin/notifications.html.twig', ['notifications'=>$notifications]);
    }

    /**
     * @Route("/admin/articles-list", name="admin_articles-list")
     */
    public function articlesListAction()
    {
        return $this->render('admin/articles_list.html.twig');
    }

    private function loggedAdmin()
    {
        $securityToken = $this->get('security.token_storage')->getToken();

        $admin = $securityToken ? $securityToken->getUsername(): '';

        if (!$admin) {
            return 0;
        } else {
            $admin = $this->get('app.repository.admin')->findBy(['username' => $admin]);
            return $admin[0]->getId();
        }
    }
}