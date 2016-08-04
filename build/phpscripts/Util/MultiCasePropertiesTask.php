<?php

/**
 * MultiCasePropertiesTask.php
 *
 * @category mage2-code-generator
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */

require_once 'phing/Task.php';

class MultiCasePropertiesTask extends Task
{
    public function main()
    {
        foreach ($this->project->getUserProperties() as $property => $value) {
            if (false !== strpos($property, 'phing')) {
                continue;
            }
            $propertyUcFirst = ucfirst($property);
            $valueUcFirst = ucfirst($value);
            $propertyLcFirst = lcfirst($property);
            $valueLcFirst = lcfirst($value);
            $this->project->setUserProperty($propertyUcFirst, $valueUcFirst);
            $this->project->setUserProperty($propertyLcFirst, $valueLcFirst);
        }
    }
}