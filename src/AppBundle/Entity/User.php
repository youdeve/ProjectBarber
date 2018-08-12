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
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
    * @ORM\ManyToOne(targetEntity="Groups", inversedBy="users")
    */
    protected $groups;

     /**
      * @ORM\ManyToMany(targetEntity="ServiceList", inversedBy="users")
      */
    protected $serviceList;



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
}
