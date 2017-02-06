<?php
/**
 * TemplateGenerateCommand
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Command\Template;

use Staempfli\Mg2CodeGenerator\Helper\MagentoHelper;
use Staempfli\UniversalGenerator\Command\Template\AbstractTemplateCommand;
use Staempfli\UniversalGenerator\Command\Template\TemplateGenerateCommand as UniversalTemplateGenerateCommand;

class TemplateGenerateCommand extends UniversalTemplateGenerateCommand
{
    const TEMPLATE_MODULE = 'module';
    const TEMPLATE_LANGUAGE = 'language';

    /**
     * @var MagentoHelper
     */
    protected $magentoHelper;

    /**
     * @var array
     */
    protected $moduleNoRequiredTemplates = [
        self::TEMPLATE_MODULE,
        self::TEMPLATE_LANGUAGE,
    ];

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->magentoHelper = new MagentoHelper();
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeExecute()
    {
        if ($this->shouldCreateNewModule()) {
            $this->io->text([
                sprintf('Module is not existing at the specified path %s', $this->fileHelper->getRootDir()),
                'Code generator needs to be executed in a valid module.'
            ]);
            if (!$this->io->confirm('Would you like to create a new module now?', true)) {
                throw new \Exception(sprintf('Module could not be found in %s', $this->fileHelper->getRootDir()));
            }
            $this->generateTemplateModule();
        }
        return true;
    }

    /**
     * @return bool
     */
    protected function shouldCreateNewModule()
    {
        if (!$this->magentoHelper->moduleExist() && !in_array($this->templateName, $this->moduleNoRequiredTemplates)) {
            return true;
        }
        return false;
    }

    /**
     * @return string $resultCode
     */
    protected function generateTemplateModule()
    {
        $originalTemplate = $this->templateName;
        $this->updateTemplateArgument(self::TEMPLATE_MODULE);

        $this->execute($this->io->getInput(), $this->io->getOutput());

        $this->updateTemplateArgument($originalTemplate);
    }

    /**
     * @param string $templateName
     */
    protected function updateTemplateArgument($templateName)
    {
        $this->io->getInput()->setArgument(AbstractTemplateCommand::ARG_TEMPLATE, $templateName);
        $this->setTemplate($this->io->getInput());
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeAskInputProperties()
    {
        if (!in_array($this->templateName, $this->moduleNoRequiredTemplates)) {
            $this->setModuleProperties();
        }
    }

    protected function setModuleProperties()
    {
        $moduleProperties = $this->magentoHelper->getModuleProperties();
        if ($moduleProperties) {
            $this->propertiesTask->addProperties($moduleProperties);
        }
    }

}