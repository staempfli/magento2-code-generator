<?php
/**
 * GenerateCodeTask
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Tasks;

use Staempfli\Mg2CodeGenerator\Helper\ConfigHelper;
use Staempfli\Mg2CodeGenerator\Helper\FileHelper;
use Staempfli\Mg2CodeGenerator\Helper\PropertiesHelper;

class GenerateCodeTask
{
    public function generateCodeFromTemplate($template)
    {
        $this->executeDependencies($template);
        // Get Default properties
        // Get Magento properties if not "module" template
        // Ask input properties
        // Process properties lower and upper
        // Generate code files replacing placeholders
        // After Generate

        $fileHelper = new FileHelper();
        $propertiesHelper = new PropertiesHelper();

    }

    protected function executeDependencies($template)
    {
        $configHelper = new ConfigHelper();
        $templateDependencies = $configHelper->getTemplateDependencies($template);
        if ($templateDependencies) {
            foreach ($templateDependencies as $templateDependency) {
                $this->runDependency($templateDependency);
            }
        }
    }

    protected function runDependency($templateDependency)
    {
        // Inform user whether is ok or not to run this dependency
        // If OK -> call template:generate $templateDependency
    }
}