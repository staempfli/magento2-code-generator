<?php
/**
 * TemplateListCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TemplateListCommand extends Command
{
    /**
     * Configure Command
     */
    protected function configure()
    {
        $this->setName('template:list')
            ->setDescription('Show list of possible templates to generate code.')
            ->setHelp("This command checks all available templates to generate code from.");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('TODO: list all available template');
    }

}