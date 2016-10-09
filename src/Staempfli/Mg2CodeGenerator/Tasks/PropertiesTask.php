<?php
/**
 * PropertiesTask
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Tasks;

use Staempfli\Mg2CodeGenerator\Helper\FileHelper;
use Staempfli\Mg2CodeGenerator\Helper\PropertiesHelper;
use Staempfli\Mg2CodeGenerator\Helper\TemplateHelper;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

class PropertiesTask
{
    /**
     * Properties to be used during code generation
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Default properties filename
     *
     * @var string
     */
    protected $defaultPropertiesFilename = 'config/default-properties.yml';

    /**
     * Properties Helper
     *
     * @var PropertiesHelper
     */
    protected $propertiesHelper;
    /**
     * @var SymfonyStyle
     */
    protected $io;

    /**
     * PropertiesTask constructor.
     * @param SymfonyStyle $io
     */
    public function __construct(SymfonyStyle $io)
    {
        $this->propertiesHelper = new PropertiesHelper();
        $this->io = $io;
    }

    /**
     * Set property
     *
     * @param $property
     * @param $value
     */
    public function setProperty($property, $value)
    {
        $this->properties[$property] = $value;
    }

    /**
     * Add properties
     * - $properties format must be an array like ['propertyName', 'propertyValue']
     *
     * @param array $properties
     */
    public function addProperties(array $properties)
    {
        $this->properties = array_merge($this->properties, $properties);
    }

    /**
     * Get Properties
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Get Default properties file path
     *
     * @return string
     */
    public function getDefaultPropertiesFile()
    {
        $fileHelper = new FileHelper();
        return $fileHelper->getUsersHome() . '/.mg2-codegen/' . $this->defaultPropertiesFilename;
    }

    /**
     * Check whether the default properties configuration is set
     *
     * @return bool
     */
    public function defaultPropertiesExist()
    {
        if (file_exists($this->getDefaultPropertiesFile())) {
            return true;
        }
        return false;
    }

    /**
     * Set Default Properties configuration file in user's home
     * @throws \Exception
     */
    public function setDefaultPropertiesConfigurationFile()
    {
        $fileHelper = new FileHelper();
        $originalPropertiesFilename = $fileHelper->getProjectBaseDir() . '/' . $this->defaultPropertiesFilename;
        $originalProperties = Yaml::parse(file_get_contents($originalPropertiesFilename));

        $defaultProperties = [];
        foreach ($originalProperties as $property => $value) {
            if (!$value) {
                $defaultProperties[$property] = $this->io->ask($property);
            }
        }
        // Create user's home configuration file
        $userConfigDir = dirname($this->getDefaultPropertiesFile());
        if (!is_dir($userConfigDir)) {
            if (!mkdir($userConfigDir, 0766, true)) {
                throw new \Exception('Not possible to create user\'s configuration file: '. $this->getDefaultPropertiesFile());
            }
        }

        // Save properties in user's home dir
        file_put_contents($this->getDefaultPropertiesFile(), Yaml::dump($defaultProperties));
    }

    /**
     * Set Default Properties
     */
    public function loadDefaultProperties()
    {
        $defaultProperties = Yaml::parse(file_get_contents($this->getDefaultPropertiesFile()));
        $this->addProperties($defaultProperties);
    }

    /**
     * Output default properties
     */
    public function displayLoadedProperties()
    {
        $defaultProperties = $this->getProperties();
        $ioTableContent = [];
        foreach ($defaultProperties as $property => $value) {
            $ioTableContent[] = [$property, $value];
        }

        $this->io->table(['property', 'value'], $ioTableContent);
    }

    /**
     * Ask user and set the properties need in template
     *
     * @param $templateName
     */
    public function askAndSetInputPropertiesForTemplate($templateName)
    {
        $templateProperties = $this->getAllPropertiesInTemplate($templateName);
        $propertiesAlreadyAsked = [];
        foreach ($templateProperties as $property) {
            if ($this->shouldAskForProperty($property, $propertiesAlreadyAsked)) {
                $value = $this->io->ask($property);
                $this->setProperty($property, $value);
                $propertiesAlreadyAsked[] = $property;
            }
        }
    }

    /**
     * Get all properties in template
     *
     * @param $templateName
     * @return array
     */
    protected function getAllPropertiesInTemplate($templateName)
    {
        $templateHelper = new TemplateHelper();
        $fileIterator = $templateHelper->getTemplateFilesIterator($templateName);
        $propertiesInTemplate = [];
        foreach ($fileIterator as $file) {
            $propertiesInFilename = $this->propertiesHelper->getPropertiesInText($file->getPathname());
            $propertiesInCode = $this->propertiesHelper->getPropertiesInText(file_get_contents($file->getPathname()));
            $propertiesInTemplate = array_merge($propertiesInTemplate, $propertiesInFilename, $propertiesInCode);
        }
        return $propertiesInTemplate;
    }

    /**
     * Check whether the property should be added to the list of properties to ask
     *
     * @param $property
     * @param array $propertiesAlreadyAsked
     * @return bool
     */
    protected function shouldAskForProperty($property, array $propertiesAlreadyAsked)
    {
        // Case insensitive check among current properties to ask
        if (in_array(strtolower($property), array_map('strtolower', $propertiesAlreadyAsked))) {
            return false;
        }
        // Case insensitive check among already existing properties
        if (in_array(strtolower($property), array_map('strtolower', array_keys($this->properties)))) {
            return false;
        }
        return true;
    }

    /**
     * Generate MultiCase properties
     * - That way, the user does not need to input same value for properties with different casing format
     */
    public function generateMultiCaseProperties()
    {
        foreach ($this->properties as $property => $value) {
            $propertyUcFirst = ucfirst($property);
            $valueUcFirst = ucfirst($value);
            $this->setProperty($propertyUcFirst, $valueUcFirst);
            $propertyLcFirst = lcfirst($property);
            $valueLowerCaseFirst = strtolower($value);
            $this->setProperty($propertyLcFirst, $valueLowerCaseFirst);
        }
    }

}