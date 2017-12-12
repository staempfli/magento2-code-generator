<?php
/**
 * ImageFactory
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Model\${Entityname}\Attribute\Backend;

use InvalidArgumentException;
use Magento\Framework\ObjectManagerInterface;

class ImageFactory
{
    const IMAGE_ATTRIBUTE_CODES = [
        ${Fileattributename}::ATTRIBUTE_CODE => ${Fileattributename}::class,
    ];

    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    protected $objectManager = null;

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
     * @param $imageAttributeCode
     * @param array $data
     * @return ObjectType
     */
    public function create(string $imageAttributeCode, array $data = [])
    {
        if (empty(self::IMAGE_ATTRIBUTE_CODES[$imageAttributeCode])) {
            throw new InvalidArgumentException(sprintf('"%s": isn\'t allowed', $imageAttributeCode));
        }

        $resultInstance = $this->objectManager->create(self::IMAGE_ATTRIBUTE_CODES[$imageAttributeCode], $data);
        if (!$resultInstance instanceof ImageAbstract) {
            throw new InvalidArgumentException(sprintf('%s isn\'t instance of %s',
                get_class($resultInstance),
                ImageAbstract::class
            ));
        }

        return $resultInstance;
    }
}