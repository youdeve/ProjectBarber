<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Group;
use AppBundle\Entity\User;

class LoadGroup implements FixtureInterface
{

  protected $container;

  public function __construct()
  {

  }

  /**
 * @param ObjectManager $manager
 */
  public function load(ObjectManager $manager)
  {
      $this->createTestUsers($manager);
  }


  /**
 * @param ObjectManager $manager
 */
private function createTestUsers(ObjectManager $manager)
{
  $userManager = $this->container->get('fos_user.user_manager');

  $users = [];
  $users[] = array('email' => 'admin@kabolt.fr',
      'groups' => array('GROUP_ADMIN'),
      'lastname' => 'Dujardin', 'firstname' => 'Thomas');

  $users[] = array('email' => 'superadmin@kabolt.fr',
      'groups' => array('GROUP_ADMIN'),
      'roles' => array('ROLE_UPDATE_THINCLIENT',
          'ROLE_REBOOT_THINCLIENT',
          'ROLE_CHANGE_POLLING_FREQUENCY',
          'ROLE_THINCLIENT_SCREENSHOTS',
          'ROLE_DOWNLOAD_TEMPLATE'),
      'lastname' => 'BurdyGillou', 'firstname' => 'SuperAdmins');

  $users[] = array('email' => 'landlord@kabolt.fr',
      'groups' => array('GROUP_LANDLORD'),
      'roles' => array('ROLE_READ_MESSAGE', 'ROLE_SEND_MESSAGE', 'ROLE_PUBLICMESSAGE', 'ROLE_PUBLICPAGE', 'ROLE_PUBLICPAGE_VIDEO'),
      'lastname' => 'Lebailleur', 'firstname' => 'Nicolas');

  $users[] = array('email' => 'superlandlord@kabolt.fr',
      'groups' => array('GROUP_SUPERLANDLORD'),
      'roles' => array('ROLE_PUBLICPAGE_VIDEO'),
      'lastname' => 'Lemanager', 'firstname' => 'Marc');

  $users[] = array('email' => 'concierge@kabolt.fr',
      'groups' => array('GROUP_CONCIERGE'),
      'lastname' => 'Lagardienne', 'firstname' => 'Michelle');

  foreach ($users as $user) {
    $newUser = $userManager->createUser();
    $newUser->setUsername($user['email']);
    $newUser->setEmail($user['email']);
    $newUser->setFirstName($user['firstname']);
    $newUser->setLastName($user['lastname']);
    $newUser->setPlainPassword('KaboltDev42');
    $newUser->setEnabled(true);

    if (array_key_exists('roles', $user)) {
      foreach ($user['roles'] as $roleName) {
        $newUser->addRole($roleName);
      }
    }

    foreach ($user['groups'] as $groupName) {
      $newUser->addGroup($manager->getRepository('AppBundle:Group')->findOneByName($groupName));
    }

    $userManager->updateUser($newUser, true);
  }
}
}
