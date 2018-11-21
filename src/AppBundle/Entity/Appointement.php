<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Appointement
 *
 * @ORM\Table(name="appointement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AppointementRepository")
 */
class Appointement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_appointement", type="datetime")
     */
    private $startAppointement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_appointement", type="datetime")
     */
    private $endAppointement;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="User",  inversedBy="affectedAgentBarber")
     */
    protected $barber;

    /**
     * @ORM\ManyToOne(targetEntity="User",  inversedBy="User")
     */
    protected $customer;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startAppointement.
     *
     * @param \DateTime $startAppointement
     *
     * @return Appointement
     */
    public function setStartAppointement($startAppointement)
    {
        $this->startAppointement = $startAppointement;

        return $this;
    }

    /**
     * Get startAppointement.
     *
     * @return \DateTime
     */
    public function getStartAppointement()
    {
        return $this->startAppointement;
    }

    /**
     * Set endAppointement.
     *
     * @param \DateTime $endAppointement
     *
     * @return Appointement
     */
    public function setEndAppointement($endAppointement)
    {
        $this->endAppointement = $endAppointement;

        return $this;
    }

    /**
     * Get endAppointement.
     *
     * @return \DateTime
     */
    public function getEndAppointement()
    {
        return $this->endAppointement;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Appointement
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set barber.
     *
     * @param \AppBundle\Entity\User|null $barber
     *
     * @return Appointement
     */
    public function setBarber(\AppBundle\Entity\User $barber = null)
    {
        $this->barber = $barber;

        return $this;
    }

    /**
     * Get barber.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getBarber()
    {
        return $this->barber;
    }

    /**
     * Set customer.
     *
     * @param \AppBundle\Entity\User|null $customer
     *
     * @return Appointement
     */
    public function setCustomer(\AppBundle\Entity\User $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
