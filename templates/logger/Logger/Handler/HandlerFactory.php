<?php
/**
 * HandlerFactory
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Logger\Handler;

use InvalidArgumentException;
use Magento\Framework\ObjectManagerInterface;
use ${Vendorname}\${Modulename}\Logger\Handler\HandlerAbstract as ObjectType;

class HandlerFactory
{
    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    protected $objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $instanceTypeNames = [
        'error' => '\\${Vendorname}\\${Modulename}\\Logger\\Handler\\Error',
        'info' => '\\${Vendorname}\\${Modulename}\\Logger\\Handler\\Info',
        'debug' => '\\${Vendorname}\\${Modulename}\\Logger\\Handler\\Debug',
    ];

    /**
     * Factory constructor
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create corresponding class instance
     *
     * @param $type
     * @param array $data
     * @return ObjectType
     */
    public function create($type, array $data = array())
    {
        if (empty($this->instanceTypeNames[$type])) {
            throw new InvalidArgumentException('"' . $type . ': isn\'t allowed');
        }

        $resultInstance = $this->objectManager->create($this->instanceTypeNames[$type], $data);
        if (!$resultInstance instanceof ObjectType) {
            throw new InvalidArgumentException(get_class($resultInstance) . ' isn\'t instance of \${Vendorname}\${Modulename}\Logger\Handler\HandlerAbstract');
        }

        return $resultInstance;
    }
}