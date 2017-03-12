<?php
/**
 * EavTablesSetup
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;

class EavTablesSetup
{
    /**
     * @var SchemaSetupInterface
     */
    protected $setup;

    /**
     * EavTablesSetup constructor.
     * @param SchemaSetupInterface $setup
     */
    public function __construct(SchemaSetupInterface $setup)
    {
        $this->setup = $setup;
    }

    public function createEavTables($entityCode)
    {
        $this->createEAVMainTable($entityCode);
        $this->createEntityTable($entityCode, 'datetime', Table::TYPE_DATETIME);
        $this->createEntityTable($entityCode, 'decimal', Table::TYPE_DECIMAL, '12,4');
        $this->createEntityTable($entityCode, 'int', Table::TYPE_INTEGER);
        $this->createEntityTable($entityCode, 'text', Table::TYPE_TEXT, '64k');
        $this->createEntityTable($entityCode, 'varchar', Table::TYPE_TEXT, 255);
    }

    protected function createEAVMainTable($entityCode)
    {
        $tableName = $entityCode . '_eav_attribute';

        $table = $this->setup->getConnection()->newTable(
            $this->setup->getTable($tableName)
        )->addColumn(
            'attribute_id',
            Table::TYPE_SMALLINT,
            null,
            ['identity' => false, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Attribute Id'
        )->addColumn(
            'is_global',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '1'],
            'Is Global'
        )->addColumn(
            'is_filterable',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Is Filterable'
        )->addColumn(
            'is_visible',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '1'],
            'Is Visible'
        )->addColumn(
            'validate_rules',
            Table::TYPE_TEXT,
            '64k',
            [],
            'Validate Rules'
        )->addColumn(
            'is_system',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Is System'
        )->addColumn(
            'sort_order',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Sort Order'
        )->addColumn(
            'data_model',
            Table::TYPE_TEXT,
            255,
            [],
            'Data Model'
        )->addForeignKey(
            $this->setup->getFkName($tableName, 'attribute_id', 'eav_attribute', 'attribute_id'),
            'attribute_id',
            $this->setup->getTable('eav_attribute'),
            'attribute_id',
            Table::ACTION_CASCADE
        )->setComment(
            $entityCode . 'Eav Attribute'
        );
        $this->setup->getConnection()->createTable($table);
    }

    protected function createEntityTable($entityCode, $type, $valueType, $valueLength = null)
    {
        $tableName = $entityCode . '_entity_' . $type;

        $table = $this->setup->getConnection()
            ->newTable($this->setup->getTable($tableName))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )
            ->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute ID'
            )
            ->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                $valueLength,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity ID'
            )
            ->addColumn(
                'value',
                $valueType,
                null,
                [],
                'Value'
            )
            ->addIndex(
                $this->setup->getIdxName(
                    $tableName,
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addIndex(
                $this->setup->getIdxName($tableName, ['entity_id']),
                ['entity_id']
            )
            ->addIndex(
                $this->setup->getIdxName($tableName, ['attribute_id']),
                ['attribute_id']
            )
            ->addIndex(
                $this->setup->getIdxName($tableName, ['store_id']),
                ['store_id']
            )
            ->addForeignKey(
                $this->setup->getFkName(
                    $tableName,
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $this->setup->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $this->setup->getFkName(
                    $tableName,
                    'entity_id',
                    $entityCode,
                    'entity_id'
                ),
                'entity_id',
                $this->setup->getTable($entityCode . '_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $this->setup->getFkName($tableName, 'store_id', 'store', 'store_id'),
                'store_id',
                $this->setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )
            ->setComment($entityCode . ' ' . $type . 'Attribute Backend Table');
        $this->setup->getConnection()->createTable($table);
    }
}
