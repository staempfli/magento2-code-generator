<?php
/**
 * MagentoHelper
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Helper;

use Staempfli\UniversalGenerator\Helper\FileHelper;

class MagentoHelper
{
    const MODULE_REGISTRATION_FILE = 'registration.php';

    /**
     * @var FileHelper
     */
    protected $fileHelper;

    public function __construct()
    {
        $this->fileHelper = new FileHelper();
    }

    /**
     * @return bool
     */
    public function moduleExist()
    {
        return file_exists($this->getRegistrationFileAbsolutePath());
    }

    /**
     * @return string
     */
    protected function getRegistrationFileAbsolutePath()
    {
        return $this->fileHelper->getRootDir() . '/' . self::MODULE_REGISTRATION_FILE;
    }

    /**
     * @throws \Exception
     */
    public function getModuleProperties()
    {
        if (!$this->moduleExist()) {
            throw new \Exception(sprintf
                (
                    '%s not existing at current dir. Please check that your registration.php is correct and try again',
                    self::MODULE_REGISTRATION_FILE
                )
            );
        }

        $moduleProperties = [];
        $registrationContent = file_get_contents($this->getRegistrationFileAbsolutePath());
        $moduleProperties['Vendorname'] = preg_match("/[',\"](.*?)_/", $registrationContent, $match) ? $match[1] : false;
        $moduleProperties['Modulename'] = preg_match("/_(.*?)[',\"]/", $registrationContent, $match) ? $match[1] : false;
        if (!$moduleProperties['Vendorname'] || !$moduleProperties['Modulename']) {
            throw new \Exception(sprintf
                (
                    'VendorName and ModuleName could not be found on %s. Please check that your module setup is correct and try again',
                    self::MODULE_REGISTRATION_FILE
                )
            );
        }

        return $moduleProperties;
    }
}