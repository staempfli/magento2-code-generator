<?php
/**
 * installSchema.php
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use ${Vendorname}\${Modulename}\Setup\EavTablesSetupFactory;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var EavTablesSetupFactory
     */
    protected $eavTablesSetupFactory;

    /**
     * Init
     *
     * @internal param EavTablesSetupFactory $EavTablesSetupFactory
     */
    public function __construct(EavTablesSetupFactory $eavTablesSetupFactory)
    {
        $this->eavTablesSetupFactory = $eavTablesSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        $setup->startSetup();

        $eavTableName = ${Entityname}Setup::ENTITY_TYPE_CODE . '_entity';
        /**
         * Create entity Table
         */
        $eavTable = $setup->getConnection()
            ->newTable($setup->getTable($eavTableName))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )->setComment('Entity Table');

        $eavTable->addColumn(
            'identifier',
            Table::TYPE_TEXT,
            100,
            ['nullable' => false],
            'Identifier'
        )->addIndex(
            $setup->getIdxName($eavTableName, ['identifier']),
            ['identifier']
        );

        // Add more static attributes here...

        $eavTable->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation Time'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Update Time'
        );
        $setup->getConnection()->createTable($eavTable);
        /** @var \${Vendorname}\${Modulename}\Setup\EavTablesSetup $eavTablesSetup */
        $eavTablesSetup = $this->eavTablesSetupFactory->create(['setup' => $setup]);
        $eavTablesSetup->createEavTables(${Entityname}Setup::ENTITY_TYPE_CODE);

        /**
         * Create table '${vendorname}_${modulename}_${simpleentityname}'
         */
        $fileTableName = '${vendorname}_${modulename}_${simpleentityname}';
        $fileTable = $setup->getConnection()->newTable(
            $setup->getTable($fileTableName)
        )->addColumn(
            'id',
            Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'id'
        )->addIndex(
            $setup->getIdxName($fileTableName, ['id']),
            ['id']
        )->setComment(
            '${Entityname} ${Simpleentityname}'
        );
        $fileTable->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Foreign Key entity_id'
        )->addForeignKey(
            $setup->getFkName($fileTableName, 'entity_id', $eavTableName, 'entity_id'),
            'entity_id',
            $setup->getTable($eavTableName),
            'entity_id',
            Table::ACTION_CASCADE
        );
        $fileTable->addColumn(
            'filename',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'filename'
        );
        $fileTable->addColumn(
            'link',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'link'
        );
        $fileTable->addColumn(
            'position',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '0'],
            'position'
        );
        $setup->getConnection()->createTable($fileTable);

        $setup->endSetup();
    }
}
