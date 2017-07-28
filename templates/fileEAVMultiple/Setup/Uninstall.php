<?php

/**
 * Uninstall.php
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Uninstall implements UninstallInterface
{
    /**
     * @var array
     */
    protected $tablesToUninstall = [
        ${Entityname}Setup::ENTITY_TYPE_CODE . '_entity',
        ${Entityname}Setup::ENTITY_TYPE_CODE . '_eav_attribute',
        ${Entityname}Setup::ENTITY_TYPE_CODE . '_entity_datetime',
        ${Entityname}Setup::ENTITY_TYPE_CODE . '_entity_decimal',
        ${Entityname}Setup::ENTITY_TYPE_CODE . '_entity_int',
        ${Entityname}Setup::ENTITY_TYPE_CODE . '_entity_text',
        ${Entityname}Setup::ENTITY_TYPE_CODE . '_entity_varchar'
    ];

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        $setup->startSetup();

        foreach ($this->tablesToUninstall as $table) {
            if ($setup->tableExists($table)) {
                $setup->getConnection()->dropTable($setup->getTable($table));
            }
        }
        if ($setup->tableExists('${vendorname}_${modulename}_${simpleentityname}')) {
            $setup->getConnection()->dropTable($setup->getTable('${vendorname}_${modulename}_${simpleentityname}'));
        }

        $setup->endSetup();
    }
}
