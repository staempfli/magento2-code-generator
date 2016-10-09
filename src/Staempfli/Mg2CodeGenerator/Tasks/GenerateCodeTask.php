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
use Staempfli\Mg2CodeGenerator\Helper\TemplateHelper;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateCodeTask
{
    /**
     * @var string
     */
    protected $templateName;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @var SymfonyStyle
     */
    protected $io;

    /**
     * @var FileHelper
     */
    protected $fileHelper;

    /**
     * @var TemplateHelper
     */
    protected $templateHelper;

    /**
     * GenerateCodeTask constructor.
     * @param $templateName
     * @param array $properties
     * @param SymfonyStyle $io
     */
    public function __construct($templateName, array $properties, SymfonyStyle $io)
    {
        $this->templateName = $templateName;
        $this->properties = $properties;
        $this->io = $io;
    }

    /**
     * Get File Helper
     *
     * @return FileHelper
     */
    protected function getFileHelper()
    {
        if (!$this->fileHelper) {
            $this->fileHelper = new FileHelper();
        }

        return $this->fileHelper;
    }

    /**
     * Get Template Helper
     *
     * @return TemplateHelper
     */
    protected function getTemplateHelper()
    {
        if (!$this->templateHelper) {
            $this->templateHelper = new TemplateHelper();
        }

        return $this->templateHelper;
    }

    /**
     * Generate code
     * - Generates code according to template and properties set on constructor
     * @param bool $dryRun
     */
    public function generateCode($dryRun = false)
    {
        $templateFilesIterator = $this->getTemplateHelper()->getTemplateFilesIterator($this->templateName);
        $propertiesHelper = new PropertiesHelper();
        foreach ($templateFilesIterator as $file) {
            // skip configuration files
            if (strpos($file->getPathname(), ConfigHelper::TEMPLATE_CONFIG_FOLDER) !== false) {
                continue;
            }
            $filename = $propertiesHelper->replacePropertiesInText($file->getPathname(), $this->properties);
            $fileContent = $propertiesHelper->replacePropertiesInText(file_get_contents($file->getPathname()), $this->properties);
            $this->generateFileWithContent($filename, $fileContent, $dryRun);
        }

    }

    /**
     * Generate and write file
     *
     * @param $filename
     * @param $fileContent
     * @param bool $dryRun
     */
    protected function generateFileWithContent($filename, $fileContent, $dryRun = false)
    {
        $filenameAbsolutePath = $this->getAbsolutePathToCopyTo($filename);
        if (file_exists($filenameAbsolutePath)) {
            if (!$this->shouldOverwriteFile($filename)) {
                $this->showInfoFileNotCopied($filename, $fileContent);
                return;
            }
        }

        // Do not create any files on dryRun mode
        if (!$dryRun) {
            $this->prepareDirToWriteTo($filenameAbsolutePath);
            if(!file_put_contents($filenameAbsolutePath, $fileContent)) {
                $this->io->error(sprintf('There was an error copying the file "%s"', $filename));
                $this->showInfoFileNotCopied($filename, $fileContent);
                return;
            }
        }

        $this->io->writeln(sprintf('<info>File Created: %s', $this->getRelativePathToCopyTo($filename)));
    }

    /**
     * Get relative path to Template for file
     *
     * @param $filename
     * @return string
     */
    protected function getRelativePathToCopyTo($filename)
    {
        $relativePath = substr($filename, strlen($this->getTemplateHelper()->getTemplateDir($this->templateName)));
        $relativePathFixed = ltrim($relativePath, '/');
        return $relativePathFixed;
    }

    /**
     * Get Absolute path to copy files to
     *
     * @param $filename
     * @return string
     */
    protected function getAbsolutePathToCopyTo($filename)
    {
        return $this->getFileHelper()->getModuleDir() . '/' . $this->getRelativePathToCopyTo($filename);
    }

    /**
     * Confirm with user whether to override existing file
     *
     * @param $filename
     * @return bool|string
     */
    protected function shouldOverwriteFile($filename)
    {
        $filenameRelativePath = $this->getRelativePathToCopyTo($filename);
        return $this->io->confirm(sprintf('%s already exists, would you like to overwrite it?', $filenameRelativePath), false);
    }

    /**
     * Display info for not copied file
     * - That way, the user can manually copy this content if needed
     *
     * @param $filename
     * @param $templateContent
     */
    protected function showInfoFileNotCopied($filename, $templateContent)
    {
        $filenameRelativePath = $this->getRelativePathToCopyTo($filename);
        $this->io->warning(sprintf('%s NOT generated', $filenameRelativePath));
        $this->io->text($templateContent);
        $this->io->note(sprintf('You can copy the previous code and add it manually on %s', $filenameRelativePath));
    }

    /**
     * Prepare directory where file will be written into
     *
     * @param $filenameAbsolutePath
     */
    protected function prepareDirToWriteTo($filenameAbsolutePath)
    {
        $dirToWrite = dirname($filenameAbsolutePath);
        if (!is_dir($dirToWrite)) {
            mkdir($dirToWrite, 0777, true);
        }
    }

}