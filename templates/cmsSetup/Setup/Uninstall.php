<?php

/**
 * Uninstall.php
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Cms\Setup\PageFactory;
use Magento\Cms\Setup\BlockFactory;
use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class Uninstall implements UninstallInterface
{

    /**
     *  page factory
     *
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     *  block factory
     *
     * @var BlockFactory
     */
    protected $blockFactory;
    /**
     * Init
     *
     * @param PageFactory $pageFactory
     * @param BlockFactory $blockFactory
     */
    public function __construct(PageFactory $pageFactory, BlockFactory $blockFactory)
    {
        $this->pageFactory = $pageFactory;
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function uninstall(ModuleDataSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        $setup->startSetup();

        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->removeAttribute(\Magento\${Entitymodule}\Model\${Entity}::ENTITY, '${attribute_name}')

        $setup->endSetup();
    }
}
