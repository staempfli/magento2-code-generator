<?php

/**
 * GetModuleProperties
 *
 * @category mage2-code-generator
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */

require_once "phing/Task.php";

class GetModulePropertiesTask extends Task
{
    public function main()
    {
        $registrationContent = file_get_contents($this->project->getProperty('application.startdir'). '/registration.php');
        preg_match("/'(.*?)_/", $registrationContent, $match);
        $this->project->setUserProperty('vendorname', $match[1]);
        preg_match('/_(.*?)[\',"]/', $registrationContent, $match);
        $this->project->setUserProperty('modulename', $match[1]);
    }
}