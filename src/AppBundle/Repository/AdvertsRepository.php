<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Adverts;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
/**
 * AdvertsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertsRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByUserId($userId){
        $query = $this->_em->createQueryBuilder()->select("u")->from('AppBundle:Adverts','u')->where('u.user_id=:user_id')->setParameter(':user_id', $userId)->getQuery();
        $adverts = $query->getResult();
        return $adverts;
    }

    public function findPaginated($offset){
        $offset = ($offset - 1) * 10;
        $query = $this->_em->createQueryBuilder()->select("u")->from('AppBundle:Adverts','u')->where('u.public=1')->andWhere('u.blocked=0')->orderBy('u.date_added', 'DESC')->setFirstResult($offset)->setMaxResults(10)->getQuery();
        $adverts = $query->getResult();
        return $adverts;
    }

    public function findAvailable(){
        $query = $this->_em->createQueryBuilder()->select("u")->from('AppBundle:Adverts','u')->where('u.public=1')->andWhere('u.blocked=0')->getQuery();
        $adverts = $query->getResult();
        return $adverts;
    }

    public function findUserPaginated($offset, $userId) {
        $offset = ($offset -1) * 6;
        $query = $this->_em->createQueryBuilder()->select("u")->from('AppBundle:Adverts','u')->where('u.user_id=:user_id')->setParameter(':user_id', $userId)->setFirstResult($offset)->setMaxResults(6)->getQuery();
        $adverts = $query->getResult();
        return $adverts;
    }

    public function findByPhrase($searchedPhrase) {
        $query = $this->_em->createQueryBuilder()->select("a")->from('AppBundle:Adverts','a')->where('a.title LIKE :phrase')
            ->setParameter(':phrase', '%' . $searchedPhrase . '%')->orderBy('a.date_added', 'DESC')
            ->getQuery();
        $adverts = $query->getResult();
        return $adverts;
    }

    public function filterSearch($params) {

        $query = $this->_em->createQueryBuilder()->select("a")->from('AppBundle:Adverts','a')->where('1 = 1');

        //establishing search params
        if ($params['category']) {
            $query = $query->andWhere('a.category = :category');
        }

        if ($params['voivodeship']) {
            $query = $query->andWhere('a.voivodeship_id = :voivodeship');
        }

        // establishing params's values
        if ($params['category']) {
            $query = $query->setParameter(':category', $params['category']);
        }

        if ($params['voivodeship']) {
            $query = $query->setParameter(':voivodeship', $params['voivodeship']);
        }
        $query = $query->orderBy('a.date_added', 'DESC');

        $query = $query->getQuery();
        $adverts = $query->getResult();

        // check cities
        if ($params['city'] && $adverts) {
            $adverts_result = [];
            foreach($adverts as $advert) {
                $advert_cities = [];
                foreach ($advert->getCities() as $city) {
                    $advert_cities[] = $city->getName();
                }
                if (in_array($params['city'], $advert_cities)) {
                    array_push($adverts_result, $advert);
                }
            }
            $adverts = $adverts_result;
        }

        return $adverts;
    }
}
