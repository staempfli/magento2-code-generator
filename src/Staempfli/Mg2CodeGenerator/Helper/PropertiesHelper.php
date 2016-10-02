<?php
/**
 * PropertiesHelper
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Helper;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

class PropertiesHelper
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
     * @param SymfonyStyle $io
     * @throws \Exception
     */
    public function setDefaultPropertiesConfigurationFile(SymfonyStyle $io)
    {
        $fileHelper = new FileHelper();
        $originalPropertiesFilename = $fileHelper->getProjectBaseDir() . '/' . $this->defaultPropertiesFilename;
        $originalProperties = Yaml::parse(file_get_contents($originalPropertiesFilename));

        $defaultProperties = [];
        foreach ($originalProperties as $property => $value) {
            if (!$value) {
                $defaultProperties[$property] = $io->ask($property);
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
     * @param SymfonyStyle $io
     */
    public function displayLoadedProperties(SymfonyStyle $io)
    {
        $defaultProperties = $this->getProperties();
        $ioTableContent = [];
        foreach ($defaultProperties as $property => $value) {
            $ioTableContent[] = [$property, $value];
        }

        $io->table(['property', 'value'], $ioTableContent);
    }
}