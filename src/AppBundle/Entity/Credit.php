<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Credit
 *
 * @ORM\Table(name="credit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CreditRepository")
 */
class Credit
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
     * @ORM\Column(name="title", type="string", length=30)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $affectedAdmin;

    /**
     * @var int
     *
     * @ORM\Column(name="credit", type="integer")
     */
    private $credit;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;


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
     * Set credit.
     *
     * @param int $credit
     *
     * @return Credit
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * Get credit.
     *
     * @return int
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return Credit
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
     * Set title.
     *
     * @param string $title
     *
     * @return Credit
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
     * Set affetedAdmin.
     *
     * @param \AppBundle\Entity\User|null $affetedAdmin
     *
     * @return Credit
     */
    public function setAffetedAdmin(\AppBundle\Entity\User $affetedAdmin = null)
    {
        $this->affetedAdmin = $affetedAdmin;

        return $this;
    }

    /**
     * Get affetedAdmin.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getAffetedAdmin()
    {
        return $this->affetedAdmin;
    }
}
