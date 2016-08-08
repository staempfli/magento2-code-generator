<?php

/**
 * InputParamsTask.php
 *
 * @category mage2-code-generator
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */

require_once 'GeneratorAbstract.php';

class InputParamsTask extends GeneratorAbstract
{
    protected $_propertiesToAsk = array();

    public function main()
    {
        $templateDir = $this->_getTemplateDir();
        $fileIterator = $this->_getFilesIterator($templateDir);

        foreach ($fileIterator as $file) {
            $this->_setPropertiesToAskFromPlaceholdersInText($file->getPathname());
            $this->_setPropertiesToAskFromPlaceholdersInText(file_get_contents($file->getPathname()));
        }

        foreach ($this->_propertiesToAsk as $property) {
            $request = new InputRequest($property . ' :');
            $this->project->getInputHandler()->handleInput($request);
            $value = $request->getInput();
            if ($value !== null) {
                $this->project->setUserProperty($property, $value);
            }
        }
    }

    protected function _setPropertiesToAskFromPlaceholdersInText($text)
    {
        preg_match_all('/\$\{([^\$}]+)\}/', $text, $matches);
        foreach ($matches[1] as $property) {
            if (!$this->_propertyExists($property)) {
                $this->_propertiesToAsk[] = $property;
            }
        }
    }

    protected function _propertyExists($property)
    {
        // Case insensitive check among properties to ask
        if (in_array(strtolower($property), array_map('strtolower', $this->_propertiesToAsk))) {
            return true;
        }

        // Case insensitive check among already existing properties
        if (in_array(strtolower($property), array_map('strtolower', array_keys($this->project->getProperties())))) {
            return true;
        }

        return false;
    }


}
