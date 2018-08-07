<?php
/**
 * InstallData
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Cms\Setup\PageFactory;
use Magento\Cms\Setup\BlockFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
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
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        $setup->startSetup();

        /** @var \Magento\Cms\Model\Block $block */
        $page = $this->pageFactory->create(['setup' => $setup]);

        $cmsPageData = [
            'title' => '<custom>', // cms page title
            'page_layout' => '<custom>', // cms page layout eg. 1column
            'meta_keywords' => '<custom>', // cms page meta keywords
            'meta_description' => '<custom>', // cms page description
            'identifier' => '${identifier}', // cms page url identifier
            'content_heading' => '<custom>', // Page heading
            'content' => "<custom>", // page content
            'is_active' => 1, // define active status
            'stores' => [0], // assign to stores
            'sort_order' => 0 // page sort order
        ];

        // create page
        $page->setData($cmsPageData)->save();

        /** @var \Magento\Cms\Model\Block $block */
        /*// $block = $this->blockFactory->create(['setup' => $setup]);

        $cmsBlockData = [
            'title' => '<custom>', // block title
            'identifier' => '${identifier}', //block identifier
            'content' => "<custom>", //bock content
            'is_active' => 1,  // define active status
            'stores' => [0], // assign to stores
            'sort_order' => 0 // block sort order
        ];

        // create block
        $block->create()->setData($cmsBlockData)->save();
        */

        $setup->endSetup();
    }
}
