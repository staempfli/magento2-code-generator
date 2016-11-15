<?php
/**
 * Logger
 *
 * @copyright Copyright (c) ${commentsYear} ${CommentsCompanyName}
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Logger;

use Monolog\Logger;
use ${Vendorname}\${Modulename}\Logger\Handler\FactoryHandler;

class ${LoggerName} extends Logger
{
    /**
     * @var array
     */
    protected $defaultHandlerTypes = [
        'error',
        'info',
        'debug'
    ];

    /**
     * {@inheritdoc}
     */
    public function __construct(FactoryHandler $factoryHandler, $name = '${loggerName}', array $handlers = [], array $processors = [])
    {
        foreach ($this->defaultHandlerTypes as $handlerType) {
            if (!array_key_exists($handlerType, $handlers)) {
                $handlers[$handlerType] = $factoryHandler->create($handlerType);
            }
        }
        parent::__construct($name, $handlers, $processors);
    }

}
