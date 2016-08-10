<?php
/**
 * ${Entityname}Setup
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
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

        // Add your entity attributes here...

        $attributes['image'] = [
            'type' => 'varchar',
            'label' => 'Image',
            'input' => 'image',
            'backend' => 'Staempfli\${Modulename}\Model\${Entityname}\Attribute\Backend\Image',
            'required' => false,
            'sort_order' => 10,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'group' => 'General',
        ];

        $attributes['title'] = [
            'type' => 'varchar',
            'label' => 'Title',
            'input' => 'text',
            'required' => true,
            'sort_order' => 20,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General',
            'validate_rules' => 'a:2:{s:15:"max_text_length";i:255;s:15:"min_text_length";i:1;}',
        ];

        $attributes['description'] = [
            'type' => 'text',
            'label' => 'Description',
            'input' => 'textarea',
            'required' => true,
            'sort_order' => 30,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General',
            'wysiwyg_enabled' => true,
        ];

        $attributes['link'] = [
            'type' => 'varchar',
            'label' => 'Link',
            'input' => 'text',
            'required' => true,
            'sort_order' => 40,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General',
            'validate_rules' => 'a:2:{s:15:"max_text_length";i:255;s:15:"min_text_length";i:1;}',
        ];

        $attributes['is_active'] = [
            'type' => 'int',
            'label' => 'Is Active',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'sort_order' => 50,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General',
        ];

        $attributes['date_from'] = [
            'type' => 'datetime',
            'label' => 'Date From',
            'input' => 'date',
            'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
            'required' => false,
            'sort_order' => 60,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General',
        ];

        $attributes['date_to'] = [
            'type' => 'datetime',
            'label' => 'Date To',
            'input' => 'date',
            'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
            'required' => false,
            'sort_order' => 70,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General',
        ];

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
                'entity_model' => 'Staempfli\${Modulename}\Model\ResourceModel\${Entityname}',
                'attribute_model' => 'Staempfli\${Modulename}\Model\ResourceModel\Eav\Attribute',
                'table' => self::ENTITY_TYPE_CODE . '_entity',
                'increment_model' => null,
                'additional_attribute_table' => self::ENTITY_TYPE_CODE . '_eav_attribute',
                'entity_attribute_collection' => 'Staempfli\${Modulename}\Model\ResourceModel\Attribute\Collection',
                'attributes' => $this->getAttributes()
            ]
        ];

        return $entities;
    }
}
