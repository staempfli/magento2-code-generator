<?php
/**
 * Debug
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Logger\Handler;

use Monolog\Logger;

class Debug extends HandlerAbstract
{
    /**
     * @var string
     */
    protected $fileName = 'debug.log';

    /**
     * @var int
     */
    protected $loggerType = Logger::DEBUG;
}
