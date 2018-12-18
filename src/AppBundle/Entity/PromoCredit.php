<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PromoCredit
 *
 * @ORM\Table(name="promo_credit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromoCreditRepository")
 */
class PromoCredit
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
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $affectedAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


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
     * Set code.
     *
     * @param string $code
     *
     * @return PromoCredit
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return PromoCredit
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set affectedAdmin.
     *
     * @param \AppBundle\Entity\User|null $affectedAdmin
     *
     * @return PromoCredit
     */
    public function setAffectedAdmin(\AppBundle\Entity\User $affectedAdmin = null)
    {
        $this->affectedAdmin = $affectedAdmin;

        return $this;
    }

    /**
     * Get affectedAdmin.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getAffectedAdmin()
    {
        return $this->affectedAdmin;
    }
}
