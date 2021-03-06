<?php

namespace AppBundle\Repository;

/**
 * City
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class City extends \Doctrine\ORM\EntityRepository
{
    public function findByVoivodeship($voivodeship_id) {
        $city_names = [];
        $query = $this->_em->createQueryBuilder()->select('c.name')->from('AppBundle:City','c')->where('c.voivodeship=:id')->setParameter(':id', $voivodeship_id)->getQuery();
        $cities = $query->getResult();
        foreach ($cities as $name) {
            $city_names[] = $name;
        }
        return $city_names;
    }

    public function findByName($name) {
        $query = $this->_em->createQueryBuilder()->select('c')->from('AppBundle:City','c')->where('c.name=:name')->setParameter(':name', $name)->getQuery();
        $city_names = $query->getResult();
        return $city_names[0];
    }
}
