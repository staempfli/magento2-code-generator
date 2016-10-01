<?php
/**
 * TemplateInfoCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TemplateInfoCommand extends Command
{
    /**
     * Configure Command
     */
    protected function configure()
    {
        $this->setName('template:info')
            ->setDescription('Show extended info of specific template.')
            ->setHelp("This command displays a description of what the template does.")
            ->addArgument('template', InputArgument::REQUIRED, 'The template to show description for.');
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
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Template Information',
            '====================='
        ]);

        $output->writeln('Template name: ' . $input->getArgument('template'));
        $output->writeln('');
        $output->writeln('TODO: Show full description of selected Template');
    }

}