<?php
/**
 * TemplateGenerateCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Command;

use Staempfli\UniversalGenerator\Helper\FileHelper;
use Staempfli\Mg2CodeGenerator\Helper\MagentoHelper;
use Staempfli\UniversalGenerator\Tasks\PropertiesTask;
use Staempfli\UniversalGenerator\Command\TemplateGenerateCommand as UniversalTemplateGenerateCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TemplateGenerateCommand extends UniversalTemplateGenerateCommand
{
    /**
     * Template name for creating a new module
     *
     * @var string
     */
    protected $moduleTemplate = 'module';

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    protected function beforeAskInputProperties($templateName, PropertiesTask $propertiesTask, SymfonyStyle $io)
    {
        if ($templateName != $this->moduleTemplate) {
            $io->section('Loading Magento Properties');
            $magentoHelper = new MagentoHelper();
            try {
                $moduleProperties = $magentoHelper->getModuleProperties();
            } catch (\Exception $e) {
                $io->error($e->getMessage());
                return;
            }
            $propertiesTask->addProperties($moduleProperties);
        }

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
}