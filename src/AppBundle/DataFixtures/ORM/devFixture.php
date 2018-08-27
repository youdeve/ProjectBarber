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
        $newUserT->setUsername('FrancLemanager');
        $newUserT->setEmail('francTeam@barber.fr');
        $newUserT->setPlainPassword('123456');//123456
        $newUserT->setEnabled(true);
        $newUserT->addRole("ROLE_CLIENT");

        $userManager->updateUser($newUserT, true);

        $newUserT = $userManager->createUser();
        $newUserT->setUsername('Thomas');
        $newUserT->setEmail('Thomas@barber.fr');
        $newUserT->setPlainPassword('123456');//123456
        $newUserT->setEnabled(true);
        $newUserT->addRole("ROLE_CLIENT");

        $userManager->updateUser($newUserT, true);

        $newUser2 = $userManager->createUser();
        $newUser2->setUsername('AntoineLeManager');
        $newUser2->setEmail('antoineTeam@barber.fr');
        $newUser2->setPlainPassword('123456');//123456
        $newUser2->setEnabled(true);
        $newUser2->addRole("ROLE_TEAM");

        $userManager->updateUser($newUser2, true);

        $newUser21 = $userManager->createUser();
        $newUser21->setUsername('PhilipLeManager');
        $newUser21->setEmail('philipTeam@barber.fr');
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

        $clients = [];

        $clients[] = [
          "username" => "Vernon",
          "mail" => "vernon@barber.fr",
          "password" => "123456",
          "enabled" => true,
          "roles" => "ROLE_CLIENT"
        ];

        $clients[] = [
          "username" => "Charles",
          "mail" => "Charles@barber.fr",
          "password" => "123456",
          "enabled" => true,
          "roles" => "ROLE_CLIENT"
        ];

        $clients[] = [
          "username" => "Patricia",
          "mail" => "Patricia@barber.fr",
          "password" => "123456",
          "enabled" => true,
          "roles" => "ROLE_CLIENT"
        ];
        $clients[] = [
          "username" => "Edna",
          "mail" => "Edna@barber.fr",
          "password" => "123456",
          "enabled" => true,
          "roles" => "ROLE_CLIENT"
        ];
        $clients[] = [
          "username" => "Iris",
          "mail" => "Iris@barber.fr",
          "password" => "123456",
          "enabled" => true,
          "roles" => "ROLE_CLIENT"
        ];
        $clients[] = [
          "username" => "Eva",
          "mail" => "Eva@barber.fr",
          "password" => "123456",
          "enabled" => true,
          "roles" => "ROLE_CLIENT"
        ];
        $clients[] = [
          "username" => "John",
          "mail" => "John@barber.fr",
          "password" => "123456",
          "enabled" => true,
          "roles" => "ROLE_CLIENT"
        ];
        $clients[] = [
          "username" => "Call",
          "mail" => "Call@barber.fr",
          "password" => "123456",
          "enabled" => true,
          "roles" => "ROLE_CLIENT"
        ];
        $clients[] = [
          "username" => "King",
          "mail" => "King@barber.fr",
          "password" => "123456",
          "enabled" => true,
          "roles" => "ROLE_CLIENT"
        ];
        $clients[] = [
          "username" => "Johnson",
          "mail" => "Johnson@barber.fr",
          "password" => "123456",
          "enabled" => true,
          "roles" => "ROLE_CLIENT"
        ];
        foreach ($clients as $client) {
            $clients = $userManager->createUser();
              $clients->setUsername($client['username']);
              $clients->setEmail($client['mail']);
              $clients->setPlainPassword($client['password']);//123456
              $clients->setEnabled($client['enabled']);
              $clients->addRole($client['roles']);

              $userManager->updateUser($clients, true);
        }

        //affectedAgentBarber
        // $User = $manager->getRepository(User::class)->findAll();
        $agentTeam = $manager->getRepository(User::class)->findOneByEmail("philipTeam@barber.fr");
        // $clients = $manager->getRepository(User::class)->findBy(["roles" => "ROLE_CLIENT"]);
        // foreach ($clients as $client) {
        //   $mailClient = $client->getEmail();
        //   $affectedAgentBarber = $client->setAffectedAgentBarber($agentTeam);
        //   $manager->persist($affectedAgentBarber);
        // }
        $client = $manager->getRepository(User::class)->findOneByEmail('Thomas@barber.fr');
        $client2 = $manager->getRepository(User::class)->findOneByEmail('Iris@barber.fr');
        $client3 = $manager->getRepository(User::class)->findOneByEmail('Johnson@barber.fr');
        $client4 = $manager->getRepository(User::class)->findOneByEmail('King@barber.fr');
        $client5 = $manager->getRepository(User::class)->findOneByEmail('King@barber.fr');

        $affectedAgentBarber = $client->setAffectedAgentBarber($agentTeam);
        $affectedAgentBarber = $client2->setAffectedAgentBarber($agentTeam);
        $affectedAgentBarber = $client3->setAffectedAgentBarber($agentTeam);
        $affectedAgentBarber = $client4->setAffectedAgentBarber($agentTeam);
        $affectedAgentBarber = $client5->setAffectedAgentBarber($agentTeam);

        //affectedAgentBarber
        $agentTeam = $manager->getRepository(User::class)->findOneByEmail("antoineTeam@barber.fr");
        $client = $manager->getRepository(User::class)->findOneByEmail('jean@barber.fr');
        $client2 = $manager->getRepository(User::class)->findOneByEmail("eva@barber.fr");
        $client3 = $manager->getRepository(User::class)->findOneByEmail("john@barber.fr");
        $client4 = $manager->getRepository(User::class)->findOneByEmail("Call@barber.fr");


        $affectedAgentBarber = $client->setAffectedAgentBarber($agentTeam);
        $affectedAgentBarber = $client2->setAffectedAgentBarber($agentTeam);
        $affectedAgentBarber = $client3->setAffectedAgentBarber($agentTeam);
        $affectedAgentBarber = $client4->setAffectedAgentBarber($agentTeam);

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

          $ServiceLists[] = [
            "haircut" => "coupe carré",
            "dateHaircut" => $date,
            "price" => "12",
            'user' => 'Thomas@barber.fr'
          ];

          $ServiceLists[] = [
            "haircut" => "Tout court",
            "dateHaircut" => $date,
            "price" => "23",
            'user' => 'Thomas@barber.fr'
          ];

          $ServiceLists[] = [
            "haircut" => "Coupe oval",
            "dateHaircut" => $date,
            "price" => "25",
            'user' => 'eva@barber.fr'
          ];

          $ServiceLists[] = [
            "haircut" => "coupe Normal",
            "dateHaircut" => $date,
            "price" => "29",
            'user' => 'johnson@barber.fr'
          ];
          $ServiceLists[] = [
            "haircut" => "coupe long",
            "dateHaircut" => $date,
            "price" => "50",
            'user' => 'Charles@barber.fr'

          ];

          $ServiceLists[] = [
            "haircut" => "coupe carré",
            "dateHaircut" => $date,
            "price" => "12",
            'user' => 'Charles@barber.fr'
          ];

          $ServiceLists[] = [
            "haircut" => "Coupe moi",
            "dateHaircut" => $date,
            "price" => "23",
            'user' => 'Iris@barber.fr'
          ];

          $ServiceLists[] = [
            "haircut" => "Coupe Carré",
            "dateHaircut" => $date,
            "price" => "5",
            'user' => 'Edna@barber.fr'
          ];

          $ServiceLists[] = [
            "haircut" => "coloration",
            "dateHaircut" => $date,
            "price" => "65",
            'user' => 'Vernon@barber.fr'
          ];
          $ServiceLists[] = [
            "haircut" => "Super",
            "dateHaircut" => $date,
            "price" => "59",
            'user' => 'King@barber.fr'

          ];

          $ServiceLists[] = [
            "haircut" => "coupe triangle",
            "dateHaircut" => $date,
            "price" => "10",
            'user' => 'Charles@barber.fr'
          ];

          $ServiceLists[] = [
            "haircut" => "court",
            "dateHaircut" => $date,
            "price" => "3",
            'user' => 'call@barber.fr'
          ];


          foreach ($ServiceLists as $ServiceList) {
            $u = $manager->getRepository(User::class)->findOneByEmail($ServiceList['user']);
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
