<?php

/**
 * InputParamsTask.php
 *
 * @category mage2-code-generator
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */

require_once 'phing/Task.php';
include_once 'phing/input/InputRequest.php';

class InputParamsTask extends Task
{
    public function main()
    {
        $params = $this->project->getProperty('params');
        if ($params) {
            $params = explode(',', $params);
            foreach ($params as $param) {
                $request = new InputRequest($param . ' :');
                $this->project->getInputHandler()->handleInput($request);
                $value = $request->getInput();
                if ($value !== null) {
                    $this->project->setUserProperty($param, $value);
                }
            }
        }
    }
}
