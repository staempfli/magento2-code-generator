<?php
/**
 * ConfigSetCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Command;

use Staempfli\Mg2CodeGenerator\Tasks\PropertiesTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConfigSetCommand extends Command
{
    /**
     * Command configuration
     */
    public function configure()
    {
        $this->setName('config:set')
            ->setDescription('Set Global Configuration.')
            ->setHelp('This commands sets the global configuration for code generation.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->writeln('<comment>Set Configuration</comment>');

        $propertiesTask = new PropertiesTask();
        $propertiesTask->setDefaultPropertiesConfigurationFile($io);

        $io->success(sprintf('Configuration set into %s', $propertiesTask->getDefaultPropertiesFile()));
    }
}