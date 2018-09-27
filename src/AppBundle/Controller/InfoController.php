<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\EditorType;
use Symfony\Component\HttpFoundation\Response;

class InfoController extends Controller
{
    /**
     * @Route("/o-serwisie", name="about_serwis")
     */
    public function aboutSerwisAction(Request $request)
    {
        return $this->render('info/about_serwis.html.twig');
    }
    /**
     * @Route("/articles", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('info/index.html.twig', ['data'=>$data, 'dir'=>__DIR__]);
    }
    /**
     * @Route("/", name="serwis")
     */
    public function serwisAction(Request $request)
    {
        return $this->render('index3.html.twig', ['dir'=>__DIR__]);
    }
    /**
     * @Route("/panel_informacyjny", name="panel_informacyjny")
     */
    public function infoAction(Request $request)
    {
        return $this->render('info/index.html.twig');
    }
    /**
     * @Route("/panel_informacyjny/prasa/article1", name="prasa_poczatki")
     */
    public function article1Action(Request $request)
    {
        $article1 = $this->render('info/articles/press/article1.html.twig');
        $form = $this->createForm(EditorType::class, $article1);
        $editMode = $this->authorize();
        $filename = 'article1';

        if (!empty($_POST['article'])) {
            $file = fopen("../app/Resources/views/info/articles/press/article1.html.twig", "wr");
            fwrite($file, $_POST['article']);
            fclose($file);
        }
        return $this->render('info/frame.html.twig', ['editMode'=>$editMode, 'data'=>$article1, 'filename'=>$filename, 'form'=>$form->createView()]);
    }

    /**
     * @Route("/panel_informacyjny/prasa/article2", name="prasa_gutenberg")
     */
    public function article2Action(Request $request)
    {
        $article2 = $this->render('info/articles/press/article2.html.twig');
        $form = $this->createForm(EditorType::class, $article2);
        $editMode = $this->authorize();
        $filename = 'article2';

        if (!empty($_POST['article'])) {
            $file = fopen("../app/Resources/views/info/articles/press/article2.html.twig", "wr");
            fwrite($file, $_POST['article']);
            fclose($file);
        }
        return $this->render('info/frame.html.twig', ['editMode'=>$editMode, 'data'=>$article2, 'filename'=>$filename, 'form'=>$form->createView()]);
    }
    /**
     * @Route("/panel_informacyjny/prasa/article3", name="the_times")
     */
    public function article3Action(Request $request)
    {
        $article3 = $this->render('info/articles/press/article3.html.twig');
        $form = $this->createForm(EditorType::class, $article3);
        $editMode = $this->authorize();
        $filename = 'article3';

        if (!empty($_POST['article'])) {
            $file = fopen("../app/Resources/views/info/articles/press/article3.html.twig", "wr");
            fwrite($file, $_POST['article']);
            fclose($file);
        }
        return $this->render('info/frame.html.twig', ['editMode'=>$editMode, 'data'=>$article3, 'filename'=>$filename, 'form'=>$form->createView()]);
    }
    /**
     * @Route("/panel_informacyjny/prasa/article4", name="druk")
     */
    public function article4kAction(Request $request)
    {
        $article4 = $this->render('info/articles/press/article4.html.twig');
        $form = $this->createForm(EditorType::class, $article4);
        $editMode = $this->authorize();
        $filename = 'article4';

        if (!empty($_POST['article'])) {
            $file = fopen("../app/Resources/views/info/articles/press/article4.html.twig", "wr");
            fwrite($file, $_POST['article']);
            fclose($file);
        }
        return $this->render('info/frame.html.twig', ['editMode'=>$editMode, 'data'=>$article4, 'filename'=>$filename, 'form'=>$form->createView()]);
    }
    /**
     * @Route("/panel_informacyjny/prasa/article5", name="XIX_XX_wiek")
     */
    public function article5Action(Request $request)
    {
        $article5 = $this->render('info/articles/press/article5.html.twig');
        $form = $this->createForm(EditorType::class, $article5);
        $editMode = $this->authorize();
        $filename = 'article5';

        if (!empty($_POST['article'])) {
            $file = fopen("../app/Resources/views/info/articles/press/article5.html.twig", "wr");
            fwrite($file, $_POST['article']);
            fclose($file);
        }
        return $this->render('info/frame.html.twig', ['editMode'=>$editMode, 'data'=>$article5, 'filename'=>$filename, 'form'=>$form->createView()]);
    }
    /**
     * @Route("/panel_informacyjny/prasa/article6", name="reklamy_i_ogloszenia")
     */
    public function article6Action(Request $request)
    {
        $article6 = $this->render('info/articles/press/article6.html.twig');
        $form = $this->createForm(EditorType::class, $article6);
        $editMode = $this->authorize();
        $filename = 'article6';

        if (!empty($_POST['article'])) {
            $file = fopen("../app/Resources/views/info/articles/press/article6.html.twig", "wr");
            fwrite($file, $_POST['article']);
            fclose($file);
        }
        return $this->render('info/frame.html.twig', ['editMode'=>$editMode, 'data'=>$article6, 'filename'=>$filename, 'form'=>$form->createView()]);
    }
    /**
     * @Route("/panel_informacyjny/prasa/article7", name="cyfryzacja")
     */
    public function article7Action(Request $request)
    {
        $article7 = $this->render('info/articles/press/article7.html.twig');
        $form = $this->createForm(EditorType::class, $article7);
        $editMode = $this->authorize();
        $filename = 'article7';

        if (!empty($_POST['article'])) {
            $file = fopen("../app/Resources/views/info/articles/press/article7.html.twig", "wr");
            fwrite($file, $_POST['article']);
            fclose($file);
        }
        return $this->render('info/frame.html.twig', ['editMode'=>$editMode, 'data'=>$article7, 'filename'=>$filename, 'form'=>$form->createView()]);
    }
    /**
     * @Route("/panel_informacyjny/prasa/article9", name="internet")
     */
    public function articleNet1Action(Request $request)
    {
        $article9 = $this->render('info/articles/press/article9.html.twig');
        $form = $this->createForm(EditorType::class, $article9);
        $editMode = $this->authorize();
        $filename = 'article9';

        if (!empty($_POST['article'])) {
            $file = fopen("../app/Resources/views/info/articles/press/article9.html.twig", "wr");
            fwrite($file, $_POST['article']);
            fclose($file);
        }
        return $this->render('info/frame.html.twig', ['editMode'=>$editMode, 'data'=>$article9, 'filename'=>$filename, 'form'=>$form->createView()]);
    }
    /**
     * @Route("/panel_informacyjny/prasa/article10", name="tcp_ip")
     */
    public function articleNet2Action(Request $request)
    {
        $article10 = $this->render('info/articles/press/article10.html.twig');
        $form = $this->createForm(EditorType::class, $article10);
        $editMode = $this->authorize();
        $filename = 'article10';

        if (!empty($_POST['article'])) {
            $file = fopen("../app/Resources/views/info/articles/press/article10.html.twig", "wr");
            fwrite($file, $_POST['article']);
            fclose($file);
        }
        return $this->render('info/frame.html.twig', ['editMode'=>$editMode, 'data'=>$article10, 'filename'=>$filename, 'form'=>$form->createView()]);
    }

    /**
 * @Route("/panel_informacyjny/prasa/article11", name="www")
 */
    public function articleNet3Action(Request $request)
    {
        $article11 = $this->render('info/articles/press/article11.html.twig');
        $form = $this->createForm(EditorType::class, $article11);
        $editMode = $this->authorize();
        $filename = 'article11';

        if (!empty($_POST['article'])) {
            $file = fopen("../app/Resources/views/info/articles/press/article11.html.twig", "wr");
            fwrite($file, $_POST['article']);
            fclose($file);
        }
        return $this->render('info/frame.html.twig', ['editMode'=>$editMode, 'data'=>$article11, 'filename'=>$filename, 'form'=>$form->createView()]);
    }

    public function authorize() {
        $loggedUser = $this->get('security.token_storage')->getToken();
        print_r($loggedUser);
        if ($loggedUser) {
            $admins = $this->get('app.repository.admin')->findAll();
            $loggedUserEmail = $loggedUser->getEmail();
            foreach ($admins as $admin) {
                $emails[] = $admin->getEmail();
            }
            if ( in_array($loggedUserEmail, $emails) ) return $loggedUser;
        }
        return false;
    }
}
