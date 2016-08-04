<?php

/**
 * GenerateCodeTask.php
 *
 * @category mage2-code-generator
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */

require_once "phing/Task.php";
include_once 'phing/input/InputRequest.php';
include_once 'phing/input/YesNoInputRequest.php';

class GenerateCodeTask extends Task
{
    const TEMPLATES_DIR = 'templates';

    public function main()
    {
        $templatesPath = $this->project->getProperty('project.basedir') . '/' . self::TEMPLATES_DIR;
        $template = $this->project->getProperty('template');
        $templatePathName = $templatesPath . '/' . $template . '/';

        $di = new RecursiveDirectoryIterator($templatePathName);
        $di->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
            $filePathName = $this->project->replaceProperties($filename);
            $templateContent = file_get_contents($filename);
            $templateContent = $this->project->replaceProperties($templateContent);
            $fileRelativePath = substr($filePathName, strlen($templatePathName));
            $fileRelativePath = $this->project->getProperty('application.startdir') . '/' . $fileRelativePath;
//            if (file_exists($fileRelativePath)) {
//                $request = new MultipleChoiceInputRequest('File ' . $fileRelativePath . ' already exists, would you like to overwrite it?', array('y', 'n'));
//                $this->project->getInputHandler()->handleInput($request);
//                $value = $request->getInput();
//                if ($value == 'n') {
//                    echo ' file not copied: ' . $fileRelativePath;
//                    echo PHP_EOL;
//                    continue;
//                }
//            }
            $dirToWrite = dirname($fileRelativePath);
            if (!is_dir($dirToWrite)) {
                mkdir($dirToWrite, 0777, true);
            }
            if(!file_put_contents($fileRelativePath, $templateContent)) {
                echo 'file not copied: ' . $fileRelativePath;
                echo PHP_EOL;
            }
        }
    }

}