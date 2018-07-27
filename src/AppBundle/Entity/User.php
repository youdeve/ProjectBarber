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
}
