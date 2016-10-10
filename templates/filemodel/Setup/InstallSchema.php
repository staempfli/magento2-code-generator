<?php
/**
 * installSchema.php
 *
 * @copyright Copyright (c) ${commentsYear} ${CommentsCompanyName}
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        $setup->startSetup();

        /**
         * Create table '${vendorname}_${modulename}_${entityname}'
         */
        $table = $setup->getConnection()->newTable(
            $setup->getTable('${vendorname}_${modulename}_${entityname}')
        )->addColumn(
            '${database_field_id}',
            Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            '${Entityname} ID'
        )->setComment(
            '${Entityname} Table'
        );

        $table->addColumn(
            'filename',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'filename'
        );
        // Add more columns here

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
