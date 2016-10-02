<?php
/**
 * TemplateInfoCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Command;

use Staempfli\Mg2CodeGenerator\Helper\ConfigHelper;
use Staempfli\Mg2CodeGenerator\Helper\TemplateHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TemplateInfoCommand extends Command
{
    /**
     * Template arg name
     *
     * @var string
     */
    protected $templateArg = 'template';

    /**
     * Configure Command
     */
    protected function configure()
    {
        $this->setName('template:info')
            ->setDescription('Show extended info of specific template.')
            ->setHelp("This command displays a description of what the template does.")
            ->addArgument($this->templateArg, InputArgument::REQUIRED, 'The template to show description for.');
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument($this->templateArg)) {
            $io = new SymfonyStyle($input, $output);
            $template = $io->ask('Please specify a Template:', false);
            if ($template) {
                $input->setArgument($this->templateArg, $template);
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
        $io = new SymfonyStyle($input, $output);
        $io->writeln('<comment>Template Info</comment>');

        $templateName = $input->getArgument($this->templateArg);
        $templateHelper = new TemplateHelper();
        if (!$templateHelper->templateExists($templateName)) {
            $io->error(sprintf('Template "%s" does not exists', $templateName));
            $io->note('You can check the list of available templates with "mg2-codegen template:list"');
            return;
        }

        $io->title($templateName);

        $configHelper = new ConfigHelper();
        $info = $configHelper->getTemplateDescription($templateName);
        if ($info) {
            $io->text($info);
        } else {
            $io->text('Sorry, there is not info defined for this Template');
        }

        $io->newLine();
        $io->writeln([
            '<comment>Generate this template using:</comment>',
            '<info>  mg2-codegen template:generate ' . $templateName . '</info>'
        ]);
    }


}