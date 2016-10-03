<?php
/**
 * ConfigHelper
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Helper;


class ConfigHelper
{
    /**
     * Config files constants
     */
    const TEMPLATE_CONFIG_FOLDER = '.no-copied-config';

    /**
     * @var string
     */
    protected $configFilename = self::TEMPLATE_CONFIG_FOLDER . '/config.yml';
    /**
     * @var string
     */
    protected $descriptionFilename = self::TEMPLATE_CONFIG_FOLDER . '/description.txt';
    /**
     * @var string
     */
    protected $afterGenerateFilename = self::TEMPLATE_CONFIG_FOLDER . '/after-generate-info.txt';

    /**
     * Read configuration yml file and return template dependencies
     *
     * @param $template
     * @return array $templatesDependencies
     */
    public function getTemplateDependencies($template)
    {
        // Parse yml
        // return dependecies array
    }

    /**
     * Get description info for an specific template
     *
     * @param $templateName
     * @return bool|string
     */
    public function getTemplateDescription($templateName)
    {
        $templateHelper = new TemplateHelper();
        $templateDir = $templateHelper->getTemplateDir($templateName);
        $descriptionFile = $templateDir . '/' . $this->descriptionFilename;

        if (file_exists($descriptionFile)) {
            return file_get_contents($descriptionFile);
        }

        return false;
    }

    /**
     * Get after generation info for an specific template
     *
     * @param $templateName
     * @param array $properties
     * @return bool|string
     */
    public function getTemplateAfterGenerateInfo($templateName, array $properties)
    {
        $templateHelper = new TemplateHelper();
        $templateDir = $templateHelper->getTemplateDir($templateName);
        $afterGenerateFile = $templateDir . '/' . $this->afterGenerateFilename;

        if (file_exists($afterGenerateFile)) {
            $propertiesHelper = new PropertiesHelper();
            return $propertiesHelper->replacePropertiesInText(file_get_contents($afterGenerateFile), $properties);
        }

        return false;
    }
}