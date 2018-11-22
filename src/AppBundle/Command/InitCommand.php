<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader as DataFixturesLoader;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this->setName('app:init')
    ->setDescription('La command permet de remettre à zéro la base de donnée et de renouveler les fixtures.')
    ->addOption('dev', null, InputOption::VALUE_NONE, 'Si définie, charge un set de données de test')
    ->setHelp("This command allows you to create fixtures");
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $io = new SymfonyStyle($input, $output);

    $container  = $this->getContainer();
    $app = $this->getApplication();
    $em = $container->get('doctrine')->getEntityManager();

    $command = $this->getApplication()->find('doctrine:schema:drop');

    $arguments = [
      'command' => 'doctrine:schema:drop',
      '--force' => true
    ];

    $doctrineInitBase = new ArrayInput($arguments);
    $command->run($doctrineInitBase, $output);

    $command = $this->getApplication()->find('doctrine:schema:update');

    // RECREATE BASE
    $arguments = [
      'command' => 'doctrine:schema:update',
      '--force' => true
    ];

    $doctrineInitBase = new ArrayInput($arguments);
    $command->run($doctrineInitBase, $output);

    $output->writeln('Loading database default data...');

    if ($input->getOption('dev')) {

      $this->loadFixture('src/AppBundle/DataFixtures/ORM/devFixture.php', true);

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
      $output->writeln('App init successfully');

    }  else {
      // Data loading ok
      $output->writeln('Database default data loading successfully!');
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
