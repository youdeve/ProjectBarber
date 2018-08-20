<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\ServiceCatalog;
use AppBundle\Entity\ServiceList;

class devFixture  implements FixtureInterface, ContainerAwareInterface
{
    protected $container;



    public function __construct( )
    {
    }

    /**
   */
    public function load(ObjectManager $manager)
    {
        $this->createTestUsers($manager);
        $this->createServiceList($manager);
        $this->createServiceCatalog($manager);
    }


  /**
   * @param ObjectManager $manager
   */
    private function createTestUsers(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        // Admin TEST
        $newUser = $userManager->createUser();
        $newUser->setUsername('admin');
        $newUser->setEmail('admin@barber.fr');
        $newUser->setPlainPassword('$2y$13$aRbKO77ssoQKNqCScFa/yuR7teyInphJIIF88nw2ahyJ4Et4Ugedy');
        $newUser->setEnabled(true);
        $newUser->addRole("ROLE_ADMIN");

        $newUser = $userManager->createUser();
        $newUser->setUsername('TEAM');
        $newUser->setEmail('team@barber.fr');
        $newUser->setPlainPassword('$2y$13$aRbKO77ssoQKNqCScFa/yuR7teyInphJIIF88nw2ahyJ4Et4Ugedy');
        $newUser->setEnabled(true);
        $newUser->addRole("ROLE_TEAM");

        $userManager->updateUser($newUser, true);

      }

      private function createServiceList(ObjectManager $manager) {
          $userManager = $this->container->get('fos_user.user_manager');
          //ServicerList ---------
          $ServiceLists = [];
          $date = new \DateTime();

          $ServiceLists[] = [
            "haircut" => "Coupe Carré",
            "dateHaircut" => $date,
            "price" => "25",
            'user' => 'jean@barber.fr'
          ];

          $ServiceLists[] = [
            "haircut" => "coloration",
            "dateHaircut" => $date,
            "price" => "29",
            'user' => 'jean@barber.fr'
          ];
          $ServiceLists[] = [
            "haircut" => "coupe long",
            "dateHaircut" => $date,
            "price" => "50",
            'user' => 'jean@barber.fr'

          ];

          foreach ($ServiceLists as $ServiceList) {
            $u = $manager->getRepository(User::class)->findOneByEmail($ServiceList['user']);
            if(null === $u) {
              $u = $userManager->createUser();
              $u->SetEmail($ServiceList['user'])->setUsername('NewClient')
              ->setPlainPassword('$2y$13$aRbKO77ssoQKNqCScFa/yuR7teyInphJIIF88nw2ahyJ4Et4Ugedy')
              ->addRole("ROLE_CLIENT");
            }


            $s = new ServiceList();
            $s->setAffectedCustomer($u);
            $s->setHaircut($ServiceList['haircut']);
            $s->setDateHaircut($ServiceList['dateHaircut']);
            $s->setPrice($ServiceList['price']);
            $s->addUser($u);
            $userManager->updateUser($u, true);
            $manager->persist($s);
          }
          $manager->flush();
      }

      function createTeamMember(ObjectManager $manager) {
         $agentTeam = $manager->getRepository(User::class)->findOneByEmail('team@barber.fr');

         $client = $manager->getRepository(User::class)->findOneByEmail('jean@barber.fr');

         $teamMemberBarber = new TeamMember();
         $teamMemberBarber->setUser($agentTeam);
         $teamMemberBarber->setAffectedClient($client);
         $manager->persist($teamMemberBarber);
         $manager->flush();
      }

      function createServiceCatalog(ObjectManager $manager) {

        $ServiceCatalogs = [];

        $ServiceCatalogs[] = [
          "hairCuts" => "Coiffure homme",
          "price" => "35",
        ];

        $ServiceCatalogs[] = [
          "hairCuts" => "Coiffure femme",
          "price" => "19",
        ];

        $ServiceCatalogs[] = [
          "hairCuts" => "Bruhsing",
          "price" => "10",
        ];

        foreach ($ServiceCatalogs as $ServiceCatalog) {
          $catalogue = new ServiceCatalog();
          $catalogue->setHairCuts($ServiceCatalog['hairCuts']);
          $catalogue->setPrice($ServiceCatalog['price']);
          $manager->persist($catalogue);
        }
        $manager->flush();


      }


      /**
       * @param ContainerInterface|null $container
       */
      public function setContainer(ContainerInterface $container = null)
      {
        $this->container = $container;
      }


}
