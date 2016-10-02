<?php
/**
 * ConfigDisplayCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Command;

use Staempfli\Mg2CodeGenerator\Helper\PropertiesHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConfigDisplayCommand extends Command
{
    /**
     * Command configuration
     */
    public function configure()
    {
        $this->setName('config:display')
            ->setDescription('Show Global Configuration.')
            ->setHelp('This commands displays the global configuration for code generation.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->writeln('<comment>Display Configuration</comment>');

        $propertiesHelper = new PropertiesHelper();
        $propertiesHelper->loadDefaultProperties();
        $propertiesHelper->displayLoadedProperties($io);
        $io->writeln([
            '<comment>You can change this properties with:</comment>',
            '<info>  mg2-codegen config:set</info>'
        ]);
    }
}