<?php

require_once "phing/Task.php";

abstract class GeneratorAbstract extends Task
{
    const TEMPLATES_DIR = 'templates';

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

}