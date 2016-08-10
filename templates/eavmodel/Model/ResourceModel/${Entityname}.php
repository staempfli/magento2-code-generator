<?php

/**
 * ${Entityname}.php
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */

namespace ${Vendorname}\${Modulename}\Model\ResourceModel;

use Magento\Eav\Model\Entity\AbstractEntity;
use Magento\Eav\Model\Entity\Context;
use Magento\Store\Model\StoreManagerInterface;
use ${Vendorname}\${Modulename}\Setup\${Entityname}Setup;

class ${Entityname} extends AbstractEntity
{
    /**
     * Store id
     *
     * @var int
     */
    protected $_storeId = null;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->setType(${Entityname}Setup::ENTITY_TYPE_CODE);
        $this->setConnection(${Entityname}Setup::ENTITY_TYPE_CODE . '_read', ${Entityname}Setup::ENTITY_TYPE_CODE . '_write');
        $this->_storeManager = $storeManager;
    }

    /**
     * Retrieve employee entity default attributes
     *
     * @return string[]
     */
    protected function _getDefaultAttributes()
    {
        return [
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Set store Id
     *
     * @param integer $storeId
     * @return $this
     */
    public function setStoreId($storeId)
    {
        $this->_storeId = $storeId;
        return $this;
    }

    /**
     * Return store id
     *
     * @return integer
     */
    public function getStoreId()
    {
        if ($this->_storeId === null) {
            return $this->_storeManager->getStore()->getId();
        }
        return $this->_storeId;
    }
}
