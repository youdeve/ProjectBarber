<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\TeamMember;
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
        $newUser->setUsername('Jean');
        $newUser->setEmail('jean@barber.fr');
        $newUser->setPlainPassword('123456');//123456
        $newUser->setEnabled(true);
        $newUser->addRole("ROLE_CLIENT");

        $userManager->updateUser($newUser, true);

        $newUserT = $userManager->createUser();
        $newUserT->setUsername('Thomas');
        $newUserT->setEmail('Thomas@barber.fr');
        $newUserT->setPlainPassword('123456');//123456
        $newUserT->setEnabled(true);
        $newUserT->addRole("ROLE_CLIENT");

        $userManager->updateUser($newUserT, true);

        $newUser2 = $userManager->createUser();
        $newUser2->setUsername('Team');
        $newUser2->setEmail('team@barber.fr');
        $newUser2->setPlainPassword('123456');//123456
        $newUser2->setEnabled(true);
        $newUser2->addRole("ROLE_TEAM");

        $userManager->updateUser($newUser2, true);

        $newUser21 = $userManager->createUser();
        $newUser21->setUsername('Team2');
        $newUser21->setEmail('team2@barber.fr');
        $newUser21->setPlainPassword('123456');//123456
        $newUser21->setEnabled(true);
        $newUser21->addRole("ROLE_TEAM");

        $userManager->updateUser($newUser21, true);

        $newUser3 = $userManager->createUser();
        $newUser3->setUsername('admin');
        $newUser3->setEmail('admin@barber.fr');
        $newUser3->setPlainPassword('123456');//123456
        $newUser3->setEnabled(true);
        $newUser3->addRole("ROLE_ADMIN");

        $userManager->updateUser($newUser3, true);

        $agentTeam = $manager->getRepository(User::class)->findOneByEmail('team2@barber.fr');
        $client = $manager->getRepository(User::class)->findOneByEmail('Thomas@barber.fr');

        $affectedAgentBarber = $client->setAffectedAgentBarber($agentTeam);
        $manager->persist($affectedAgentBarber);
        $manager->flush();

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
            $affectedAgentBarber = $manager->getRepository(User::class)->findOneByEmail('');
            if(null === $u) {
              $u = $userManager->createUser();
              $u->SetEmail($ServiceList['user'])->setUsername('Client')
              ->setPassword('123456')//123456
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



           $teamMemberBarber = new TeamMember();
           $teamMemberBarber->setUser($agentTeam);
           $teamMemberBarber->addAffectedClient($client);


         $manager->persist($teamMemberBarber);
         $affectedAgentBarber = $client->addAffectedAgentBarber($teamMemberBarber);
         $manager->persist($affectedAgentBarber);
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
