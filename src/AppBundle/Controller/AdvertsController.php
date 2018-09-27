<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Adverts;
use Ivory\CKEditorBundle\Exception\Exception;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\AdvertType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdvertsController extends Controller
{
    /**
     * @Route("/adverts/page/{page}", name="adverts")
     */
    public function paginatedAction($page){
            $session = $this->get('session');
            $tags = [];

            if ($session->get('adverts')) {
                if ($session->get('tags')){
                    $tags[] = $session->get('tags');
                    $tags = $tags[0];
                }
                $adverts = $session->get('adverts');
                $page_number = ceil(count($adverts)/10);
                if (gettype($session->get('adverts'))  != "string"){
                    $offset = ($page - 1) * 10;
                    $adverts = array_slice($adverts, $offset, 10);
                }
            } else {
                $adverts = $this->get('app.repository.adverts')->findPaginated($page);
                $adverts_available = $this->get('app.repository.adverts')->findAvailable();
                $page_number = ceil(count($adverts_available)/10);
            }

        return $this->render('adverts/main.html.twig', array('adverts'=> $adverts, 'page_number' => $page_number, 'title' => '', 'tags'=>$tags));
    }

    /**
     * @Route("/adverts/page/{page}/{title}", name="search_title")
     */
    public function searchTitleeAction($page, $title){

            $adverts = $this->get('app.repository.adverts')->findByPhrase($title);
            $offset = ($page - 1) * 10;
            $page_number = ceil(count($adverts)/10);
            $adverts = array_slice($adverts, $offset, 10);

        return $this->render('adverts/main.html.twig', array('adverts'=> $adverts, 'page'=>$page, 'page_number' => $page_number, 'title' => $title, 'tags'=>[]));
    }

    /**
     * @Route("/ogloszenia/voivodeship", name="advert_add")
     */
    public function setCity(Request $request) {
        $voivodeshipId = $_POST['voivodeship_id'];
        $voivodeship = $this->get('app.repository.voivodeship')->find($voivodeshipId);

        return new Response($voivodeship);
    }
    /**
     * @Route("user/advert/add", name="advert_add")
     */
    public function advertAddAction(Request $request){
        $user = $this->loggedUser();

        if (!$user) {
            return $this->render('user/noAccess.html.twig');
        }

        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $request = Request::createFromGlobals();
        $advert = new Adverts();
        $addForm = $this->createForm(AdvertType::class, $advert);
        $addForm->handleRequest($request);
        $flashbag = $this->get('session')->getFlashBag();

        if($request->request->get('city')) {
            $session->set('city', $request->request->get('city'));
        }

        if($addForm->isValid() && $addForm->isSubmitted() && $session->has('city')) {
            if ($session->has('city')) {
                $photo = $advert->getPhoto();
                $city = $this->get('app.repository.city')->findByName($session->get('city'));
                $hashedPhoto = md5(uniqid()) . '.' . $photo->guessExtension();
                $photo->move($this->getParameter('photos_admin_directory'), $hashedPhoto);
                $advert->setPhoto($hashedPhoto);
                $advert->addCity($city);
                $advert->setDateAdded(new \DateTime('now'));
                $advert->setUserId($this->loggedUser()[0]);
                $advert->setBlocked(0);
                $advert->setPublic(1);
                $em->persist($advert);
                $em->flush();
                $session->remove('city');

                $flashbag->add("success", "Ogloszenie zostalo dodane");

                return $this->redirectToRoute('user_advert_added', ['advert'=>$advert, 'id'=>$advert->getId()]);
            } else {
                $flashbag->add("error", "Wystapil blad podaczas dodawania ogloszenia. Sprobuj ponownie lub skontaktuj sie z administartorem.");
            }
        }
        return $this->render('adverts/add.html.twig', ['add_form'=>$addForm->createView()]);
    }
    /**
    * @Route("/ogloszenia/cities", name="add")
    */
    public function addAction(Request $request){

        $cities = $this->get('app.repository.city')->findByVoivodeship($request->request->get('voivodeship_id'));

        return new Response(json_encode($cities));
    }
    /**
     * @Route("user/advert/{id}", name="user_advert_added")
     * @Route("advert/{id}", name="advert")
     */
    public function advertAction($id)
    {

        $advert = $this->get('app.repository.adverts')->findById($id);
        if ($advert) $advert = $advert[0];

        return $this->render('adverts/advert.html.twig', ['advert'=>$advert]);
    }

    /**
     * @Route("advert/public/{advertId}", name="advert_public")
     */
    public function changePublicAction(Request $request, $advertId) {
        $advert = $this->get('app.repository.adverts')->findById($advertId)[0];

        if ($advert){
            $advert->getPublic() ==  0 ? $advert->setPublic(1) : $advert->setPublic(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();
        }

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }

    /**
     * @Route("/adverts/delete/{id}", name="advert_delete")
     */
    public function deleteAdvertAction(Request $request, $id) {
        $advert = $this->get('app.repository.adverts')->findBy(array('id'=>$id))[0];

        if ($advert) {

            $flashbag = $this->get('session')->getFlashBag();

            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($advert);
                $em->flush();
            } catch (Exception $e) {
                $flashbag->add("deleteError", "Unable to delete advert " . $e->getMessage());
            }
        }
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
    /**
     * @Route("/adverts/filters", name="advert_filters")
     */
    public function advertFilters(Request $request) {
        $session = $this->get('session');

        if ($session->get('adverts')) {
            $session->remove('adverts');
        }
        if ($session->get('tags')) {
            $session->remove('tags');
        }

        $params['category'] = $request->request->get('category') ? $request->request->get('category') : 0;
        $params['voivodeship'] = $request->request->get('voivodeship') ? $request->request->get('voivodeship') : 0;
        $params['city'] = $request->request->get('city') ? $request->request->get('city') : 0;

        $adverts = $this->get('app.repository.adverts')->filterSearch($params);
        $session = $this->get('session');

        if ($params) {
            if ($params['voivodeship']) $params['voivodeship'] = $this->get('app.repository.voivodeship')->findById($params['voivodeship'])[0]->getName();
            $session->set('tags', $params);
        }
        if ($adverts) {
            $session->set('adverts', $adverts);
        } else {
            $session->set('adverts', 'Brak wynikow wyszukiwania');
        }

        return $this->redirectToRoute('adverts', [
            'page' => 1,
        ], 303);
    }
    /**
     * @Route("/adverts/session", name="advert_session")
     */
    public function destroyAdvertSession() {
        $session = $this->get('session');
        if ($session->get('adverts')) {
            $session->clear();
        }
        return $this->redirectToRoute('adverts', [
            'page' => 1,
        ]);
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
            return $user;
        }
    }
}