<?php
/**
 * InstallSchema
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use ${Vendorname}\${Modulename}\Setup\${Connectionname}DatabaseSetupFactory;

/**
 * Upgrade the Catalog module DB scheme
 */
class InstallSchema implements InstallSchemaInterface
{
    protected $${connectionname}DatabaseSetupFactory;

    public function __construct(${Connectionname}DatabaseSetupFactory $${connectionname}DatabaseSetupFactory)
    {
        $this->${connectionname}DatabaseSetupFactory = $${connectionname}DatabaseSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        $setup->startSetup();

        $${connectionname}DatabaseSetup = $this->${connectionname}DatabaseSetupFactory->create(['setup' => $setup]);
        $${connectionname}DatabaseSetup->setupTables($setup);

        $setup->endSetup();
    }
}
