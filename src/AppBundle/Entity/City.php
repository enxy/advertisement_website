<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Adverts;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class City
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(
 *     name="city"
 * )
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\City"
 * )
 */
class City
{
    /**
     * Primary key.
     *
     * @var integer $id
     *
     * @ORM\id
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
     * @ORM\ManyToOne(targetEntity="Voivodeship", inversedBy="cities")
     * @ORM\JoinColumn(name="voivodeship_id", referencedColumnName="id")
     */
    protected $voivodeship;
    /**
     * Many cities can have many adverts.
     * @ORM\ManyToMany(targetEntity="Adverts", mappedBy="cities")
     */
    public $adverts;
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
     * Set name
     *
     * @param string $name
     *
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set voivodeship
     *
     * @param \AppBundle\Entity\Voivodeship $voivodeship
     *
     * @return City
     */
    public function setVoivodeship(\AppBundle\Entity\Voivodeship $voivodeship = null)
    {
        $this->voivodeship = $voivodeship;

        return $this;
    }

    /**
     * Get voivodeship
     *
     * @return \AppBundle\Entity\Voivodeship
     */
    public function getVoivodeship()
    {
        return $this->voivodeship;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->adverts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add advert
     *
     * @param \AppBundle\Entity\Adverts $advert
     *
     * @return Adverts
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
