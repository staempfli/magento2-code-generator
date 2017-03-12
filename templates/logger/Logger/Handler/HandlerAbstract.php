<?php
/**
 * HandlerAbstract
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Logger\Handler;

use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Logger\Handler\Base;

class HandlerAbstract extends Base
{
    /**
     * HandlerAbstract constructor.
     *
     * Set default filePath for ${LoggerName} logs folder
     *
     * @param DriverInterface $filesystem
     * @param null|string $filePath
     */
    public function __construct(DriverInterface $filesystem, $filePath = BP . '/var/log/${loggerName}/') //@codingStandardsIgnoreLine
    {
        parent::__construct($filesystem, $filePath);
    }
}
