<?php
/**
 * TemplateListCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Command;

use Staempfli\Mg2CodeGenerator\Helper\TemplateHelper;
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
    protected function execute(InputInterface $input, OutputInterface $output) //@codingStandardsIgnoreLine
    {
        $output->writeln('<comment>Templates List</comment>');

        $templateHelper = new TemplateHelper();
        $templates = $templateHelper->getTemplatesList();

        foreach ($templates as $templateName => $type)
        {
            if ($type == 'private') {
                $templateName = $templateName . ' (Private)';
            }
            $output->writeln('<info>  ' . $templateName . '</info>');
        }

        $output->writeln('');
        $output->writeln([
            '<comment>Usage:</comment>',
            '<info>  mg2-codegen template:generate <template></info>'
        ]);
    }

}