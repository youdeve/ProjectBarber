<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ServiceList
 *
 * @ORM\Table(name="service_list")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceListRepository")
 */
class ServiceList
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
     * @var string
     *
     * @ORM\Column(name="haircut", type="string", length=255)
     */
    private $haircut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_haircut", type="datetime")
     */
    private $dateHaircut;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;


    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="ServiceList")
     */
    private $user;

    /**
     * A Service is affected to a customer (front user).
     * @Assert\NotNull(message = "A service requires a customer affected")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="affectedService")
     */
    protected $affectedCustomer;



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
     * Set haircut.
     *
     * @param string $haircut
     *
     * @return ServiceList
     */
    public function setHaircut($haircut)
    {
        $this->haircut = $haircut;

        return $this;
    }

    /**
     * Get haircut.
     *
     * @return string
     */
    public function getHaircut()
    {
        return $this->haircut;
    }

    /**
     * Set dateHaircut.
     *
     * @param \DateTime $dateHaircut
     *
     * @return ServiceList
     */
    public function setDateHaircut($dateHaircut)
    {
        $this->dateHaircut = $dateHaircut;

        return $this;
    }

    /**
     * Get dateHaircut.
     *
     * @return \DateTime
     */
    public function getDateHaircut()
    {
        return $this->dateHaircut;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return ServiceList
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return ServiceList
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        return $this->user->removeElement($user);
    }

    /**
     * Get user.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set affectedCustomer.
     *
     * @param \AppBundle\Entity\User|null $affectedCustomer
     *
     * @return ServiceList
     */
    public function setAffectedCustomer(\AppBundle\Entity\User $affectedCustomer = null)
    {
        $this->affectedCustomer = $affectedCustomer;

        return $this;
    }

    /**
     * Get affectedCustomer.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getAffectedCustomer()
    {
        return $this->affectedCustomer;
    }
}
