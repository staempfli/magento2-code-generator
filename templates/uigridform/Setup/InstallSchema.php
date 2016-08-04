<?php
/**
 * installSchema.php
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
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
        //@codingStandardsIgnoreEnd
        $setup->startSetup();

        /**
         * Create table '${vendorname}_${modulename}_${modelname}'
         */
        $table = $setup->getConnection()->newTable(
            $setup->getTable('${vendorname}_${modulename}_${modelname}')
        )->addColumn(
            '${database_field_id}',
            Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            '${Modelname} ID'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            '${Modelname} Title'
        )->addIndex(
            $setup->getIdxName(
                $setup->getTable('${vendorname}_${modulename}_${modelname}'),
                ['title'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['title'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            '${Modelname}'
        );
        $setup->getConnection()->createTable($table);


        $setup->endSetup();
    }
}
