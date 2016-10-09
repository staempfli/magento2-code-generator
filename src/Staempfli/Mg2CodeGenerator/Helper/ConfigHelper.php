<?php
/**
 * ConfigHelper
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Helper;

use Symfony\Component\Yaml\Yaml;

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
     * @var TemplateHelper
     */
    protected $templateHelper;

    /**
     * ConfigHelper constructor.
     */
    public function __construct()
    {
        $this->templateHelper = new TemplateHelper();
    }

    /**
     * Read configuration yml file and return template dependencies
     *
     * @param $templateName
     * @return array $templatesDependencies
     */
    public function getTemplateDependencies($templateName)
    {
        $dependencies = [];
        $templateDir = $this->templateHelper->getTemplateDir($templateName);
        $dependenciesFile = $templateDir . '/' . $this->configFilename;

        if (file_exists($dependenciesFile)) {
            $parsedConfig = Yaml::parse(file_get_contents($dependenciesFile));
            if (isset($parsedConfig['dependencies'])) {
                $dependencies = $parsedConfig['dependencies'];
            }
        }

        return $dependencies;
    }

    /**
     * Get description info for an specific template
     *
     * @param $templateName
     * @return bool|string
     */
    public function getTemplateDescription($templateName)
    {
        $templateDir = $this->templateHelper->getTemplateDir($templateName);
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
        $templateDir = $this->templateHelper->getTemplateDir($templateName);
        $afterGenerateFile = $templateDir . '/' . $this->afterGenerateFilename;

        if (file_exists($afterGenerateFile)) {
            $propertiesHelper = new PropertiesHelper();
            return $propertiesHelper->replacePropertiesInText(file_get_contents($afterGenerateFile), $properties);
        }

        return false;
    }
}