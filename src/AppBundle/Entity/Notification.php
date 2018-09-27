<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class Notification
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(
 *     name="notifications"
 * )
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\NotificationRepository"
 * )
 */
class Notification
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notifications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Admin", inversedBy="notifications")
     * @ORM\JoinColumn(name="admin_id", referencedColumnName="id")
     */
    protected $admin;

    /**
     * @var string $title
     *
     * @ORM\Column(
     *     name="title",
     *     type="string",
     *     length=128,
     *     nullable=false,
     * )
     */
    private $title;

    /**
     * @var string $description
     *
     * @ORM\Column(
     *     name="description",
     *     type="string",
     *     length=128,
     *     nullable=true,
     * )
     */
    private $description;

    /**
     * @ORM\Column(
     *     name="date", type="datetime", nullable=false
     * )
     */
    private $date;

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
     * Set title
     *
     * @param string $title
     *
     * @return Notification
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Notification
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Notification
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set admin
     *
     * @param \AppBundle\Entity\Admin $admin
     *
     * @return Notification
     */
    public function setAdmin(\AppBundle\Entity\Admin $admin = null)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return \AppBundle\Entity\Admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Notification
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
