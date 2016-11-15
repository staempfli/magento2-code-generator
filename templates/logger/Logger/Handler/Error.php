<?php
/**
 * Error
 *
 * @copyright Copyright (c) ${commentsYear} ${CommentsCompanyName}
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Logger\Handler;

use Monolog\Logger;

class Error extends HandlerAbstract
{
    /**
     * @var string
     */
    protected $fileName = 'error.log';

    /**
     * @var int
     */
    protected $loggerType = Logger::ERROR;
}
