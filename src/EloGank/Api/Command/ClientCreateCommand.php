<?php

namespace EloGank\Api\Command;

use EloGank\Api\Component\Command\Command;
use EloGank\Api\Configuration\ConfigurationLoader;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class ClientCreateCommand extends Command
{
    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->setName('elogank:client:create')
            ->setDescription('Create a new API client')
            ->addArgument('account_key', InputArgument::REQUIRED, 'The account key in configuration')
            ->addArgument('client_id', InputArgument::REQUIRED, 'The client id')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $accountConfiguration = ConfigurationLoader::get('client.accounts')[$input->getArgument('account_key')];

    }
}