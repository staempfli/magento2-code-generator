<?php

/**
 * ${Simpleentityname}.php
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class ${Simpleentityname} extends AbstractModel implements IdentityInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = '${vendorname}_${modulename}_${simpleentityname}';

    /**
     * @var string
     */
    protected $_cacheTag = '${vendorname}_${modulename}_${simpleentityname}';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = '${vendorname}_${modulename}_${simpleentityname}';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('${Vendorname}\${Modulename}\Model\ResourceModel\${Simpleentityname}');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Save from collection data
     *
     * @param array $data
     * @return $this|bool
     */
    public function saveCollection(array $data)
    {
        if (isset($data[$this->getId()])) {
            $this->addData($data[$this->getId()]);
            $this->getResource()->save($this);
        }
        return $this;
    }
}
