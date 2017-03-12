<?php
/**
 * ${Entityname}Setup
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;

/**
 * @codeCoverageIgnore
 */
class ${Entityname}Setup extends EavSetup
{
    /**
     * Entity type for ${Entityname} EAV attributes
     */
    const ENTITY_TYPE_CODE = '${vendorname}_${entityname}';

    /**
     * Retrieve Entity Attributes
     *
     * @return array
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function getAttributes()
    {
        $attributes = [];

        $attributes['identifier'] = [
            'type' => 'static',
            'label' => 'identifier',
            'input' => 'text',
            'required' => true,
            'sort_order' => 10,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'group' => 'General',
            'validate_rules' => 'a:2:{s:15:"max_text_length";i:100;s:15:"min_text_length";i:1;}'
        ];

        // Add your entity attributes here... For example:
//        $attributes['is_active'] = [
//            'type' => 'int',
//            'label' => 'Is Active',
//            'input' => 'select',
//            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
//            'sort_order' => 10,
//            'global' => ScopedAttributeInterface::SCOPE_STORE,
//            'group' => 'General',
//        ];

        return $attributes;
    }

    /**
     * Retrieve default entities: ${entityname}
     *
     * @return array
     */
    public function getDefaultEntities()
    {
        $entities = [
            self::ENTITY_TYPE_CODE => [
                'entity_model' => '${Vendorname}\${Modulename}\Model\ResourceModel\${Entityname}',
                'attribute_model' => '${Vendorname}\${Modulename}\Model\ResourceModel\Eav\Attribute',
                'table' => self::ENTITY_TYPE_CODE . '_entity',
                'increment_model' => null,
                'additional_attribute_table' => self::ENTITY_TYPE_CODE . '_eav_attribute',
                'entity_attribute_collection' => '${Vendorname}\${Modulename}\Model\ResourceModel\Attribute\Collection',
                'attributes' => $this->getAttributes()
            ]
        ];

        return $entities;
    }
}
