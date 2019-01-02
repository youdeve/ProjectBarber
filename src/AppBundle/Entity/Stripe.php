<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stripe
 *
 * @ORM\Table(name="stripe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StripeRepository")
 */
class Stripe
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
     * @var int
     *
     * @ORM\Column(name="tokenStipe", type="integer")
     */
    private $affectedCustomer;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, unique=true)
     */
    private $token;


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
     * Set affectedCustomer.
     *
     * @param int $affectedCustomer
     *
     * @return Stripe
     */
    public function setAffectedCustomer($affectedCustomer)
    {
        $this->affectedCustomer = $affectedCustomer;

        return $this;
    }

    /**
     * Get affectedCustomer.
     *
     * @return int
     */
    public function getAffectedCustomer()
    {
        return $this->affectedCustomer;
    }

    /**
     * Set token.
     *
     * @param string $token
     *
     * @return Stripe
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
