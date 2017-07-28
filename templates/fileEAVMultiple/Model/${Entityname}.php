<?php

/**
 * ${Entityname}.php
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Registry;
use ${Vendorname}\${Modulename}\Model\ResourceModel\${Simpleentityname}\Collection as ${Simpleentityname}Collection;

class ${Entityname} extends AbstractModel implements IdentityInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = '${vendorname}_${modulename}_${entityname}';

    /**
     * @var string
     */
    protected $_cacheTag = '${vendorname}_${modulename}_${entityname}';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = '${vendorname}_${modulename}_${entityname}';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('${Vendorname}\${Modulename}\Model\ResourceModel\${Entityname}');
    }

    /**
     * Reference constructor.
     * @param ${Simpleentityname}Collection $${simpleentityname}Collection,
     * @param ${Simpleentityname}Factory $${simpleentityname}Factory,
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        ${Simpleentityname}Collection $${simpleentityname}Collection,
        ${Simpleentityname}Factory $${simpleentityname}Factory,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
        $this->${simpleentityname}Collection = $${simpleentityname}Collection;
        $this->${simpleentityname}Factory = $${simpleentityname}Factory;
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

    /**
     * Save images once the main reference data is saved
     *
     * @return $this
     */
    public function afterSave() //@codingStandardsIgnoreLine
    {
        parent::afterSave();
        if (is_array($this->getData('dynamic_files'))) {
            $fileObject = $this->${simpleentityname}Factory->create();
            $fileObject->saveDynamicFieldFiles($this->getData('dynamic_files'), ['entity_id' => $this->getId()]);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getDynamicFiles()
    {
        return $this->${simpleentityname}Collection
            ->addFieldToFilter('entity_id', $this->getId())
            ->addOrder('position', \Magento\Framework\Data\Collection::SORT_ORDER_ASC);
    }

}
