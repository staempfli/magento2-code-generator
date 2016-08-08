<?php

require_once 'GeneratorAbstract.php';

class GetTemplatesTask extends GeneratorAbstract
{
    protected $_showList = false;

    public function setShowList($showList)
    {
        $this->_showList = $showList;
    }

    public function main()
    {
        $templates = array();

        $directoryIterator = new RecursiveDirectoryIterator($this->_getTemplateDir());
        $directoryIterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);

        foreach ($directoryIterator as $dir) {
            if ($dir->isDir()) {
                $templates[] = $dir->getFilename();
            }
        }

        $this->project->setUserProperty('templates.list', implode(',', $templates));

        if ($templates && $this->_showList) {
            $this->_printList($templates);
        }
    }

    protected function _printList($templates)
    {
        print('Templates List:' . PHP_EOL);
        print('-------------------------------------------------------------------------------' . PHP_EOL);
        foreach ($templates as $template) {
            print(' ' . $template . PHP_EOL);
        }
        print('-------------------------------------------------------------------------------' . PHP_EOL);
        print('Generate Code using the following command:' . PHP_EOL);
        print('  $ bin/mage2-generator generate -Dtemplate=<template>' . PHP_EOL);
        print('-------------------------------------------------------------------------------' . PHP_EOL);
    }
}