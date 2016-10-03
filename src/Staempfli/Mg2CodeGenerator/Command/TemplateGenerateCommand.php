<?php
/**
 * TemplateGenerateCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Command;

use Staempfli\Mg2CodeGenerator\Helper\ConfigHelper;
use Staempfli\Mg2CodeGenerator\Helper\FileHelper;
use Staempfli\Mg2CodeGenerator\Helper\MagentoHelper;
use Staempfli\Mg2CodeGenerator\Tasks\GenerateCodeTask;
use Staempfli\Mg2CodeGenerator\Tasks\PropertiesTask;
use Staempfli\Mg2CodeGenerator\Helper\TemplateHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TemplateGenerateCommand extends Command
{
    /**
     * Template arg name
     *
     * @var string
     */
    protected $templateArg = 'template';

    /**
     * Option dry run
     *
     * @var string
     */
    protected $optionDryRun = 'dry-run';

    /**
     * option module dir
     *
     * @var string
     */
    protected $moduleDir = 'module-dir';

    /**
     * Template name for creating a new module
     *
     * @var string
     */
    protected $moduleTemplate = 'module';

    /**
     * Configure Command
     */
    protected function configure()
    {
        $this->setName('template:generate')
            ->setDescription('Generate code for desired template.')
            ->setHelp("This command generates code from a specific template")
            ->addArgument($this->templateArg, InputArgument::REQUIRED, 'The template used to generate the code.')
            ->addOption(
                $this->moduleDir,
                'md',
                InputOption::VALUE_REQUIRED,
                'If specified, them generate code on this module directory'
            )
            ->addOption(
                $this->optionDryRun,
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
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        // Change directory if module dir was specifically set
        $moduleDir = $input->getOption($this->moduleDir);
        if (is_string($moduleDir)) {
            chdir($moduleDir);
        }

        // Set default properties configuration if not yet set
        $io = new SymfonyStyle($input, $output);
        $propertiesTask = new PropertiesTask();
        if (!$propertiesTask->defaultPropertiesExist()) {
            $propertiesTask->setDefaultPropertiesConfigurationFile($io);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(!$this->beforeExecute($input, $output)) {
            return;
        }
        $io = new SymfonyStyle($input, $output);
        $io->writeln('<comment>Template Generate</comment>');

        $templateName = $input->getArgument($this->templateArg);
        $templateHelper = new TemplateHelper();
        if (!$templateHelper->templateExists($templateName)) {
            $io->error(sprintf('Template "%s" does not exists', $templateName));
            $io->note('You can check the list of available templates with "mg2-codegen template:list"');
            return;
        }

        // Set properties
        $io->section('Loading Default Properties');
        $propertiesTask = new PropertiesTask();
        $propertiesTask->loadDefaultProperties();

        if ($templateName != $this->moduleTemplate) {
            $io->section('Loading Magento Properties');
            $magentoHelper = new MagentoHelper();
            $moduleProperties = $magentoHelper->getModuleProperties();
            $propertiesTask->addProperties($moduleProperties);
        }

        $propertiesTask->displayLoadedProperties($io);

        // Ask input properties
        $propertiesTask->askAndSetInputPropertiesForTemplate($templateName, $io);

        // Process properties lower and upper
        $propertiesTask->generateMultiCaseProperties();
        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $io->writeln('<info>Properties to be replaced in Template</info>');
            $propertiesTask->displayLoadedProperties($io);
        }

        $fileHelper = new FileHelper();
        $io->text(sprintf('Code will be generated at following path %s', $fileHelper->getModuleDir()));
        if (!$io->confirm('You want to continue?', true)) {
            $io->error('Execution stopped');
            return;
        }

        $io->title($templateName);

        // Generate code files
        $generateCodeTask = new GenerateCodeTask($templateName, $propertiesTask->getProperties(), $io);
        $generateCodeTask->generateCode();

        // After Generate
        $configHelper = new ConfigHelper();
        $afterGenerateInfo = $configHelper->getTemplateAfterGenerateInfo($templateName, $propertiesTask->getProperties());
        if ($afterGenerateInfo) {
            $io->warning('This template needs you to take care of the following manual steps:');
            $io->text($afterGenerateInfo);
        }

        $io->success('CODE GENERATED!');

    }

    /**
     * Some checking before command execution
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool|string $resultCode
     */
    protected function beforeExecute(InputInterface $input, OutputInterface $output)
    {
        // Check if module exists and create it otherwise
        if ($this->shouldCreateNewModule($input)) {
            $io = new SymfonyStyle($input, $output);
            $fileHelper = new FileHelper();
            $io->text([
                sprintf('Module is not existing at the specified path %s', $fileHelper->getModuleDir()),
                'Code generator needs to be executed in a valid module.'
            ]);
            if (!$io->confirm('Would you like to create a new module now?', true)) {
                $io->error(sprintf('Module could not be found in %s', $fileHelper->getModuleDir()));
                return false;
            }
            if ($this->runCommandForAnotherTemplate($this->moduleTemplate, $input, $output)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check whether a new module should be generated first
     *
     * @param InputInterface $input
     * @return bool
     */
    protected function shouldCreateNewModule(InputInterface $input)
    {
        $templateName = $input->getArgument($this->templateArg);
        $magentoHelper = new MagentoHelper();

        if (!$magentoHelper->moduleExist() && $this->moduleTemplate != $templateName) {
            return true;
        }

        return false;
    }

    /**
     * Run template generator command for specific template name
     *
     * @param $templateName
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return string $resultCode
     */
    protected function runCommandForAnotherTemplate($templateName, InputInterface $input, OutputInterface $output)
    {
        $commandName = 'template:generate';
        $command = $this->getApplication()->find($commandName);
        $arguments = [
            'command' => $commandName,
            $this->templateArg => $templateName
        ];
        foreach ($input->getOptions() as $option => $value) {
            if ($value) {
                $arguments['--' . $option] = $value;
            }
        }

        $newInput = new ArrayInput($arguments);
        return $command->run($newInput, $output);
    }

}