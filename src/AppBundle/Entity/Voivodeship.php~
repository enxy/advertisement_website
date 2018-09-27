<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class Voivodeship
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(
 *     name="voivodeship"
 * )
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\Voivodeship_city"
 * )
 */
class Voivodeship
{
    /**
     * Primary key.
     *
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(
     *     name="id",
     *     type="integer",
     *     nullable=false,
     *     options={"unsigned"=true},
     * )
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string $name
     *
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=128,
     *     nullable=false,
     * )
     */
    private $name;
    /**
     * @ORM\OneToMany(targetEntity="City", mappedBy="voivodeship", cascade={"persist", "remove"})
     */
    protected $cities;
    /**
     * @ORM\OneToMany(targetEntity="Adverts", mappedBy="voivodeship_id", cascade={"persist", "remove"})
     */
    protected $adverts;
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set voivodeship
     *
     * @param string $voivodeship
     *
     * @return Voivodeship
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get voivodeship
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function addCity(\AppBundle\Entity\City $city)
    {
        $this->cities[] = $city;

        return $this;
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Remove city
     *
     * @param \AppBundle\Entity\City $city
     */
    public function removeCity(\AppBundle\Entity\City $city)
    {
        $this->cities->removeElement($city);
    }

    /**
     * Add advert
     *
     * @param \AppBundle\Entity\Adverts $advert
     *
     * @return Voivodeship
     */
    public function addAdvert(\AppBundle\Entity\Adverts $advert)
    {
        $this->adverts[] = $advert;

        return $this;
    }

    /**
     * Remove advert
     *
     * @param \AppBundle\Entity\Adverts $advert
     */
    public function removeAdvert(\AppBundle\Entity\Adverts $advert)
    {
        $this->adverts->removeElement($advert);
    }

    /**
     * Get adverts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdverts()
    {
        return $this->adverts;
    }
}
