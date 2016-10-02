<?php
/**
 * TemplatesHelper
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Helper;


class TemplateHelper
{
    /**
     * Shared templates absolute dir
     *
     * @var string
     */
    protected $sharedTemplatesDir = BP . '/templates';
    /**
     * Private templates absolute dir
     *
     * @var string
     */
    protected $privateTemplatesDir = BP . '/privateTemplates';

    /**
     * Check if template exists
     *
     * @param $templateName
     * @return bool
     */
    public function templateExists($templateName)
    {
        if ($this->getTemplateDir($templateName)) {
            return true;
        }
        return false;
    }

    /**
     * Get template dir path
     *
     * - Private templates are more priority. If you template have the same name the private one will prevail.
     *
     * @param $templateName
     * @return string
     */
    public function getTemplateDir($templateName)
    {
        $dir = $this->privateTemplatesDir. '/' . $templateName;
        if (is_dir($dir)) {
            return $dir;
        }
        $dir = $this->sharedTemplatesDir . '/' . $templateName;
        if (is_dir($dir)) {
            return $dir;
        }
        return false;
    }

    /**
     * Get list of available templates
     *
     * @return array
     */
    public function getTemplatesList()
    {
        $templates = [];

        $fileHelper = new FileHelper();

        $directoryIterator = $fileHelper->getDirectoriesIterator($this->sharedTemplatesDir);
        foreach ($directoryIterator as $dir) {
            if ($dir->isDir()) {
                $templates[$dir->getFilename()] = 'shared';
            }
        }

        $directoryIterator = $fileHelper->getDirectoriesIterator($this->privateTemplatesDir);
        foreach ($directoryIterator as $dir) {
            if ($dir->isDir()) {
                $templates[$dir->getFilename()] = 'private';
            }
        }

        return $templates;
    }
}