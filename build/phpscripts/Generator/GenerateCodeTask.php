<?php

/**
 * GenerateCodeTask.php
 *
 * @category mage2-code-generator
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */

require_once "phing/Task.php";

class GenerateCodeTask extends Task
{
    const TEMPLATES_DIR = 'templates';

    public function main()
    {
        $templateDir = $this->_getTemplateDir();
        $fileIterator = $this->_getFilesIterator($templateDir);

        foreach ($fileIterator as $filename => $file) {
            $filename = $this->_getValueWithReplacedPlaceholders($filename);
            $templateContent = $this->_getValueWithReplacedPlaceholders(file_get_contents($filename));

            $filenameAbsolutePath = $this->_getAbsolutePathToCopyTo($filename);
            if (file_exists($filenameAbsolutePath)) {
                if (!$this->_shouldOverwriteFile($filename)) {
                    $this->_showFileNotCopied($filename, $templateContent);
                    continue;
                }
            }
            $this->_prepareDirToWriteTo($filenameAbsolutePath);
            if(!file_put_contents($filenameAbsolutePath, $templateContent)) {
                $this->log('There was an error copying the file ' . $this->_getRelativePathToCopyTo($filename), Project::MSG_ERR);
                $this->_showFileNotCopied($filename, $templateContent);
            }
            $this->log('Created: ' . $this->_getRelativePathToCopyTo($filename));
        }
    }

    protected function _getTemplateDir()
    {
        return $this->project->getProperty('project.basedir') . '/' . self::TEMPLATES_DIR . '/' . $this->project->getProperty('template');
    }

    protected function _getFilesIterator($dir)
    {
        $directoryIterator = new RecursiveDirectoryIterator($dir);
        $directoryIterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        $fileIterator = new RecursiveIteratorIterator($directoryIterator);

        return $fileIterator;
    }

    protected function _getValueWithReplacedPlaceholders($value)
    {
        return $this->project->replaceProperties($value);
    }

    protected function _getRelativePathToCopyTo($filename)
    {
        $relativePath = substr($filename, strlen($this->_getTemplateDir()));
        $relativePathFixed = ltrim($relativePath, '/');
        return $relativePathFixed;
    }

    protected function _getAbsolutePathToCopyTo($filename)
    {
        return $this->project->getProperty('application.startdir') . '/' . $this->_getRelativePathToCopyTo($filename);
    }

    protected function _shouldOverwriteFile($filename)
    {
        $filenameRelativePath = $this->_getRelativePathToCopyTo($filename);
        $request = new MultipleChoiceInputRequest($filenameRelativePath . ' already exists, would you like to overwrite it?', array('y', 'n'));
        $this->project->getInputHandler()->handleInput($request);
        if ($request->getInput() == 'n') {
            return false;
        }

        return true;
    }

    protected function _showFileNotCopied($filename, $templateContent)
    {
        $filenameRelativePath = $this->_getRelativePathToCopyTo($filename);
        $this->log($filenameRelativePath . ' not copied', Project::MSG_WARN);
        $this->log('Template Content:');
        print($templateContent);
        $this->log('You can manually copy the previous code and add it manually on ' . $filenameRelativePath, Project::MSG_WARN);
    }

    protected function _prepareDirToWriteTo($filenameAbsolutePath)
    {
        $dirToWrite = dirname($filenameAbsolutePath);
        if (!is_dir($dirToWrite)) {
            mkdir($dirToWrite, 0777, true);
        }
    }

}