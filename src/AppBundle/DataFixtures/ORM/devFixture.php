<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class devFixture implements FixtureInterface, ContainerAwareInterface
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

      $user = [];
      $user[] = ['email' =>'admin@barber.fr',
          'group' => ['GROUP_ADMIN'],
          'username' => 'LeManager'];

      $user[] = ['email' =>'Team@barber.fr',
          'group' => ['GROUP_TEAM'],
          'username' => 'theBarber'];

      $user[] = ['email' =>'client@barber.fr',
          'group' => ['GROUP_CLIENT'],
          'username' => 'LeClient'];

      foreach ($users as $user) {
        $newUser = $userManager->createUser();
        $newUser->setUsername($user['username']);
        $newUser->setEmail($user['email']);
        $newUser->setPlainPassword('123456');
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

    private function createTestData(ObjectManager $manager){
      
    }

}
