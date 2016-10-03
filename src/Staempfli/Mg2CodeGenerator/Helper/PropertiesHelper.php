<?php
/**
 * PropertiesTask
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Helper;


class PropertiesHelper
{
    /**
     * Regex to identify properties ${} in text
     *
     * @var string
     */
    protected $propertyRegex = '/\$\{([^\$}]+)\}/';

    /**
     * Properties attribute class to be able to use them on replacePropertyCallback
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Get existing properties in text
     *
     * @param $text
     * @return mixed
     */
    public function getPropertiesInText($text)
    {
        preg_match_all($this->propertyRegex, $text, $matches);
        return $matches[1];
    }

    /**
     * Replace properties in Text
     *
     * @param $text
     * @param array $properties
     * @return mixed|null
     */
    public function replacePropertiesInText($text, array $properties)
    {

        if ($text === null || !$properties) {
            return null;
        }

        $this->properties = $properties;

        $replacedText = $text;
        $iteration = 0;

        // loop to recursively replace tokens
        while (strpos($replacedText, '${') !== false) {
            $replacedText = preg_replace_callback(
                $this->propertyRegex,
                [$this, 'replacePropertyCallback'],
                $replacedText
            );

            // keep track of iterations so we can break out of otherwise infinite loops.
            $iteration++;
            if ($iteration == 5) {
                return $replacedText;
            }
        }

        return $replacedText;
    }

    /**
     * Private [static] function for use by preg_replace_callback to replace a single param.
     * This method makes use of a static variable to hold the
     * @param $matches
     * @return string
     */
    protected function replacePropertyCallback($matches)
    {
        $propertyName = $matches[1];
        if (!isset($this->properties[$propertyName])) {
            return $matches[0];
        }

        $propertyValue = $this->properties[$propertyName];
        return $propertyValue;
    }


}