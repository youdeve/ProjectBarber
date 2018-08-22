<?php

// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;



use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class User extends BaseUser
{

    public function __construct() {
        parent::__construct();
        // your own logic
    }


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="affectedAgentBarber" )
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
    * @ORM\ManyToOne(targetEntity="Groups", inversedBy="users")
    */
    protected $groups;

    /**
     * @ORM\ManyToOne(targetEntity="user")
     */
    protected $affectedAgentBarber;

    /**
     * @ORM\OneToMany(targetEntity="ServiceList", mappedBy="affectedCustomer")
     */
    protected $affectedService;

        /**
         * @param $role
         * @return bool
         */
      public function hasGroup($role) {
        return in_array( (array) $role, (array) $this->getGroups());
      }


      /**
      * {@inheritdoc}
      */
      public function getGroupNames()
      {
        $names = array();
        foreach ($this->getGroups() as $group) {
        $names[] = $group->getName();
      }

        return $names;
      }

      /**
       * @param $role
       * @return bool
       */
    public function hasRole($role) {
      return in_array($role, $this->getRoles());
    }

        /**
     * @return array
     */
    public function getRoles()
    {
      $roles = $this->roles;
      if (null !== $this->getGroups()) {
        $roles = array_merge( (array) $roles, (array) $this->getGroups()->getRoles());
      }
      return $roles;
    }

        /**
     * Get groups
     * @return array
     */
    public function getGroups()
    {
      return $this->groups;
    }

    /**
     * Set groups.
     *
     * @param \AppBundle\Entity\Groups|null $groups
     *
     * @return User
     */
    public function setGroups(\AppBundle\Entity\Groups $groups = null)
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Add serviceList.
     *
     * @param \AppBundle\Entity\ServiceList $serviceList
     *
     * @return User
     */
    public function addServiceList(\AppBundle\Entity\ServiceList $serviceList)
    {
        $this->serviceList[] = $serviceList;

        return $this;
    }

    /**
     * Remove serviceList.
     *
     * @param \AppBundle\Entity\ServiceList $serviceList
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeServiceList(\AppBundle\Entity\ServiceList $serviceList)
    {
        return $this->serviceList->removeElement($serviceList);
    }

    /**
     * Get serviceList.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiceList()
    {
        return $this->serviceList;
    }


    /**
     * Add affectedService.
     *
     * @param \AppBundle\Entity\ServiceList $affectedService
     *
     * @return User
     */
    public function addAffectedService(\AppBundle\Entity\ServiceList $affectedService)
    {
        $this->affectedService[] = $affectedService;

        return $this;
    }

    /**
     * Remove affectedService.
     *
     * @param \AppBundle\Entity\ServiceList $affectedService
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAffectedService(\AppBundle\Entity\ServiceList $affectedService)
    {
        return $this->affectedService->removeElement($affectedService);
    }

    /**
     * Get affectedService.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAffectedService()
    {
        return $this->affectedService;
    }


    /**
     * Set affectedAgentBarber.
     *
     * @param \AppBundle\Entity\user|null $affectedAgentBarber
     *
     * @return User
     */
    public function setAffectedAgentBarber(\AppBundle\Entity\user $affectedAgentBarber = null)
    {
        $this->affectedAgentBarber = $affectedAgentBarber;

        return $this;
    }

    /**
     * Get affectedAgentBarber.
     *
     * @return \AppBundle\Entity\user|null
     */
    public function getAffectedAgentBarber()
    {
        return $this->affectedAgentBarber;
    }
}
