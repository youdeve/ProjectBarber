<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Style\SymfonyStyle;
use AppBundle\Initialization\Tickets;

class PrestationCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('app:init-prestation')
      ->setDescription(
        'SHALL NOT BE RUNNED DURING PRODUCTION. Init project from scratch and loads datafixtures.')
      ->setHelp("This command allows you to create fixtures")
      ->addOption('prestations', null, InputOption::VALUE_REQUIRED, 'How many prestation the app should create?', 10)
      ->addOption('purge', 'p', InputOption::VALUE_NONE, 'purge all the prestation before initialize');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $io = new SymfonyStyle($input, $output);

    $container  = $this->getContainer();
    $app = $this->getApplication();
    $em = $container->get('doctrine')->getEntityManager();

  $io->text('Start loading fixtures...');

    if ($input->getOption('purge'))
    {
      (new ServiceList($em))->deleteLists();
      $io->success("All prestations have been deleted");
    }

    if ($input->getOption('prestations'))
    {
      if(is_numeric($input->getOption('prestations')) === true)
      {
        $io->text('Creating ' . $input->getOption('prestations') . ' prestations from <info>AppBundle\Initialization\Tickets</info> ...');
        $nbTickets = $input->getOption('prestations');
        (new Tickets($em))->load($nbTickets);
      }
      else
      {
        $io->error("A numeric value is needed for the \"prestations\" option. \n Initialization aborted without touching anything.");
      }
    }

    $io->success($input->getOption('prestation') . " prestations have been created !");

  }
}

?>
