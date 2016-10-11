<?php
/**
 * Attribute.php
 *
 * @copyright Copyright (c) ${commentsYear} ${CommentsCompanyName}
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Model\ResourceModel\Eav;

use ${Vendorname}\${Modulename}\Setup\${Entityname}Setup;
use Magento\Eav\Model\Entity\Attribute as EavAttribute;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

/**
 * Class Attribute
 * @package Staempfli\Employee\Model\ResourceModel\Eav
 */
class Attribute extends EavAttribute implements ScopedAttributeInterface
{
    /**
     * Constants
     */
    const MODULE_NAME = '${Vendorname}_${Entityname}';
    const KEY_IS_GLOBAL = 'is_global';
    const KEY_IS_STATIC = 'static';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'attribute';

    /**
     * Array with labels
     *
     * @var array
     */
    protected static $_labels = null;

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = ${Entityname}Setup::ENTITY_TYPE_CODE . '_entity_attribute';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('${Vendorname}\${Modulename}\Model\ResourceModel\Attribute');
    }

    /**
     * Processing object before save data
     *
     * @return \Magento\Framework\Model\AbstractModel
     * @throws LocalizedException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function beforeSave() //@codingStandardsIgnoreLine
    {
        $this->setData('modulePrefix', self::MODULE_NAME);
        if (isset($this->_origData[self::KEY_IS_GLOBAL])) {
            if (!isset($this->_data[self::KEY_IS_GLOBAL])) {
                $this->_data[self::KEY_IS_GLOBAL] = self::SCOPE_GLOBAL;
            }
        }
        return parent::beforeSave();
    }

    /**
     * Processing object after save data
     *
     * @return \Magento\Framework\Model\AbstractModel
     */
    public function afterSave() //@codingStandardsIgnoreLine
    {
        /**
         * Fix saving attribute in admin
         */
        $this->_eavConfig->clear();
        return parent::afterSave();
    }

    /**
     * Return is attribute global
     *
     * @return integer
     */
    public function getIsGlobal()
    {
        if ($this->getBackendType() === self::KEY_IS_STATIC) {
            return true;
        }
        return $this->_getData(self::KEY_IS_GLOBAL);
    }

    /**
     * Retrieve attribute is global scope flag
     *
     * @return bool
     */
    public function isScopeGlobal()
    {
        return $this->getIsGlobal() == self::SCOPE_GLOBAL;
    }

    /**
     * Retrieve attribute is website scope website
     *
     * @return bool
     */
    public function isScopeWebsite()
    {
        return $this->getIsGlobal() == self::SCOPE_WEBSITE;
    }

    /**
     * Retrieve attribute is store scope flag
     *
     * @return bool
     */
    public function isScopeStore()
    {
        return !$this->isScopeGlobal() && !$this->isScopeWebsite();
    }

    /**
     * Retrieve store id
     *
     * @return int
     */
    public function getStoreId()
    {
        $dataObject = $this->getDataObject();
        if ($dataObject) {
            return $dataObject->getStoreId();
        }
        return $this->getData('store_id');
    }

    /**
     * Retrieve source model
     *
     * @return \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
     */
    public function getSourceModel()
    {
        $model = $this->getData('source_model');
        if (empty($model)) {
            if ($this->getBackendType() == 'int' && $this->getFrontendInput() == 'select') {
                return $this->_getDefaultSourceModel();
            }
        }
        return $model;
    }

    /**
     * Get default attribute source model
     *
     * @return string
     */
    public function _getDefaultSourceModel()
    {
        return 'Magento\Eav\Model\Entity\Attribute\Source\Table';
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete() //@codingStandardsIgnoreLine
    {
        $this->_eavConfig->clear();
        return parent::afterDelete();
    }
}
