<?php
/**
 * AbstractHandler
 *
 * @copyright Copyright (c) ${commentsYear} ${CommentsCompanyName}
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Logger\Handler;

use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Logger\Handler\Base;

class AbstractHandler extends Base
{
    /**
     * AbstractHandler constructor.
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
