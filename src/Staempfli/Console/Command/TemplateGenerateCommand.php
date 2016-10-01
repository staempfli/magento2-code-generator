<?php
/**
 * TemplateGenerateCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TemplateGenerateCommand extends Command
{
    /**
     * Constants
     */
    const OPTION_DRY_RUN = 'dry-run';

    /**
     * Configure Command
     */
    protected function configure()
    {
        $this->setName('template:generate')
            ->setDescription('Generate code for desired template.')
            ->setHelp("This command generates code from a specific template")
            ->addArgument('template', InputArgument::REQUIRED, 'The template used to generate the code.')
            ->addOption(
                'dry-run',
                'd',
                InputOption::VALUE_NONE,
                'If specified, then no files will be actually generated.'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('template')) {
            $io = new SymfonyStyle($input, $output);
            $template = $io->ask('Please specify a Template:', false);
            if ($template) {
                $input->setArgument('template', $template);
            } else {
                $io->note('You can check the list of available templates with "mg2-codegen template:list"');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        //TODO: Load default properties (Header comments for classes)
        //TODO: if template != 'module' set Magento vendor and package variables
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
    }

}