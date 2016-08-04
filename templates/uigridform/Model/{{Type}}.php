<?php

/**
 * ${Modelname}.php
 *
 * @package  ${Modulename}
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */

namespace ${Vendorname}\${Modulename}\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use ${Vendorname}\${Modulename}\Model\ResourceModel\Reference\Collection;

class ${Modelname} extends AbstractModel implements IdentityInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = '${vendorname}_${modulename}_${modelname}';

    /**
     * @var string
     */
    protected $_cacheTag = '${vendorname}_${modulename}_${modelname}';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = '${vendorname}_${modulename}_${modelname}';
    /**
     * @var Collection
     */
    protected $referenceCollection;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('${Vendorname}\${Modulename}\Model\ResourceModel\${Modelname}');
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
     * @param Collection $referenceCollection
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource $resource
     * @param AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        Collection $referenceCollection,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->referenceCollection = $referenceCollection;
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
