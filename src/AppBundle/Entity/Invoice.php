<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvoiceRepository")
 */
class Invoice
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
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="customerId", type="integer")
     */
    private $customerId;

    /**
     * @var int
     *
     * @ORM\Column(name="serviceListId", type="integer")
     */
    private $serviceListId;


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
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Invoice
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
     * Set customerId.
     *
     * @param int $customerId
     *
     * @return Invoice
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId.
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set serviceListId.
     *
     * @param int $serviceListId
     *
     * @return Invoice
     */
    public function setServiceListId($serviceListId)
    {
        $this->serviceListId = $serviceListId;

        return $this;
    }

    /**
     * Get serviceListId.
     *
     * @return int
     */
    public function getServiceListId()
    {
        return $this->serviceListId;
    }
}
