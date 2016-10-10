<?php
/**
 * Attribute.php
 *
 * @copyright Copyright (c) ${commentsYear} ${CommentsCompanyName}
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Model\ResourceModel;

use ${Vendorname}\${Modulename}\Setup\${Entityname}Setup;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as EavAttribute;
use Magento\Eav\Model\ResourceModel\Entity\Type;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;

class Attribute extends EavAttribute
{
    /**
     * Eav config
     *
     * @var Config
     */
    protected $_eavConfig;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param Type $eavEntityType
     * @param Config $eavConfig
     * @param string $connectionName
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        Type $eavEntityType,
        Config $eavConfig,
        $connectionName = null
    ) {
        $this->_eavConfig = $eavConfig;
        parent::__construct($context, $storeManager, $eavEntityType, $connectionName);
    }

    /**
     * Perform actions after object save
     *
     * @param AbstractModel $object
     * @return $this
     */
    protected function _afterSave(AbstractModel $object)
    {
        $this->_clearUselessAttributeValues($object);
        return parent::_afterSave($object);
    }

    /**
     * Clear useless attribute values
     *
     * @param  AbstractModel $object
     * @return $this
     */
    protected function _clearUselessAttributeValues(AbstractModel $object)
    {
        $origData = $object->getOrigData();

        if ($object->isScopeGlobal() && isset(
                $origData['is_global']
            ) && ScopedAttributeInterface::SCOPE_GLOBAL != $origData['is_global']
        ) {
            $attributeStoreIds = array_keys($this->_storeManager->getStores());
            if (!empty($attributeStoreIds)) {
                $delCondition = [
                    'attribute_id = ?' => $object->getId(),
                    'store_id IN(?)' => $attributeStoreIds,
                ];
                $this->getConnection()->delete($object->getBackendTable(), $delCondition);
            }
        }

        return $this;
    }

    /**
     * Delete entity
     *
     * @param AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteEntity(AbstractModel $object)
    {
        if (!$object->getEntityAttributeId()) {
            return $this;
        }

        $select = $this->getConnection()->select()->from(
            $this->getTable('eav_entity_attribute')
        )->where(
            'entity_attribute_id = ?',
            (int)$object->getEntityAttributeId()
        );
        $result = $this->getConnection()->fetchRow($select);

        if ($result) {
            $attribute = $this->_eavConfig->getAttribute(
                ${Entityname}Setup::ENTITY_TYPE_CODE,
                $result['attribute_id']
            );

            $backendTable = $attribute->getBackend()->getTable();
            if ($backendTable) {
                $select = $this->getConnection()->select()->from(
                    $attribute->getEntity()->getEntityTable(),
                    'entity_id'
                )->where(
                    'attribute_set_id = ?',
                    $result['attribute_set_id']
                );

                $clearCondition = [
                    'attribute_id =?' => $attribute->getId(),
                    'entity_id IN (?)' => $select,
                ];
                $this->getConnection()->delete($backendTable, $clearCondition);
            }
        }

        $condition = ['entity_attribute_id = ?' => $object->getEntityAttributeId()];
        $this->getConnection()->delete($this->getTable('eav_entity_attribute'), $condition);

        return $this;
    }
}
