<?php
namespace AppBundle\Initialization;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader as DataFixturesLoader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class InitCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this->setName('app:init')
        ->setDescription('Initialisation de l\'application, A LANCER UNIQUEMENT A LA MISE EN PLACE INITIALE !')
        ->addOption('dev', null, InputOption::VALUE_NONE, 'Si définie, charge un set de données de test')
        ->addOption('preprod', null, InputOption::VALUE_NONE, 'Si définie, charge un set de données de preprod');


  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {

    $command = $this->getApplication()->find('doctrine:schema:update');

    $output->writeln('Loading database default data...');

    // INIT DEV FIXTURES
    if ($input->getOption('dev')) {

      $this->loadFixture('src/AppBundle/DataFixtures/ORM/DevFixtures.php', true);
      // Data loading ok
      $output->writeln('Database default data loading successfully!');

      // CLEAR DEV CACHE
      $command = $this->getApplication()->find('cache:clear');
      $arguments = array(
          'command' => 'cache:clear',
          '--env' => 'dev'
      );
      $clearCache = new ArrayInput($arguments);
      $command->run($clearCache, $output);
    

    } else if ($input->getOption('preprod')) {
      $this->loadFixture('src/AppBundle/DataFixtures/ORM/PreprodFixtures.php', true);
      // Data loading ok
      $output->writeln('Database preprod data loading successfully!');

      // CLEAR DEV CACHE
      $command = $this->getApplication()->find('cache:clear');
      $arguments = array(
          'command' => 'cache:clear',
          '--env' => 'dev'
      );

      $clearCache = new ArrayInput($arguments);
      $command->run($clearCache, $output);
      $output->writeln('Oecko server ready to rocks! (preprod)');

    } else {
      // Data loading ok
      $output->writeln('Database default data loading successfully!');
      $output->writeln('Oecko server ready for production!');
      $output->writeln('Please run "php bin/console cache:clear --env=prod".');
    }
  }

  protected function loadFixture($path, $append = false)
  {
    $doctrine = $this->getContainer()->get('doctrine');
    $em = $doctrine->getManager();
    $loader = new DataFixturesLoader($this->getContainer());
    $loader->loadFromFile($path);
    $fixtures = $loader->getFixtures();
    $purger = new ORMPurger($em);
    $executor = new ORMExecutor($em, $purger);
    $executor->execute($fixtures, $append);

  }

}
