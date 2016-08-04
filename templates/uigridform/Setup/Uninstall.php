<?php

/**
 * Uninstall.php
 *
 * @package  ${Modulename}
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */
//@TODO create this file manually
namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Uninstall implements UninstallInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @codingStandardsIgnoreStart
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        //@codingStandardsIgnoreEnd
        $setup->startSetup();

        if ($setup->tableExists('${vendorname}_${modulename}_${type}')) {
            $setup->getConnection()->dropTable($setup->getTable('${vendorname}_${modulename}_${type}'));
        }

        $setup->endSetup();
    }
}
