<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceCatalog
 *
 * @ORM\Table(name="service_catalog")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceCatalogRepository")
 */
class ServiceCatalog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="hairCuts", type="string", length=255)
     */
    private $hairCuts;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="credit", type="integer")
     */
    private $credit;

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
     * Set hairCuts.
     *
     * @param string $hairCuts
     *
     * @return ServiceCatalog
     */
    public function setHairCuts($hairCuts)
    {
        $this->hairCuts = $hairCuts;

        return $this;
    }

    /**
     * Get hairCuts.
     *
     * @return string
     */
    public function getHairCuts()
    {
        return $this->hairCuts;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return ServiceCatalog
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
     * Set credit.
     *
     * @param int $credit
     *
     * @return ServiceCatalog
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
}
