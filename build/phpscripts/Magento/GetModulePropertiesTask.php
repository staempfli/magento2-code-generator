<?php

/**
 * GetModuleProperties
 *
 * @category mage2-code-generator
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */

require_once "phing/Task.php";

class GetModulePropertiesTask extends Task
{
    public function main()
    {
        $registrationContent = file_get_contents($this->project->getProperty('application.startdir'). '/registration.php');
        $vendorName = preg_match("/[',\"](.*?)_/", $registrationContent, $match) ? $match[1] : false;
        $moduleName = preg_match("/_(.*?)[',\"]/", $registrationContent, $match) ? $match[1] : false;
        if (!$vendorName || !$moduleName) {
            $message = 'VendorName and ModuleName could not be found on registration.php. Please check that your registration.php is correct and try again';
            $this->log($message, Project::MSG_DEBUG);
            throw new BuildException($message);
        }
        $this->_setProperty('Vendorname', $vendorName);
        $this->_setProperty('Modulename', $moduleName);

    }

    protected function _setProperty($property, $value)
    {
        $this->project->setUserProperty($property, $value);
        $this->log($property . ' = ' . $value);
    }
}