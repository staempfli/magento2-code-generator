<?php
/**
 * InstallData
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */

namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * ${Entityname} setup factory
     *
     * @var ${Entityname}SetupFactory
     */
    protected $${entityname}SetupFactory;

    /**
     * Init
     *
     * @param ${Entityname}SetupFactory $${entityname}SetupFactory
     */
    public function __construct(${Entityname}SetupFactory $${entityname}SetupFactory)
    {
        $this->${entityname}SetupFactory = $${entityname}SetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        /** @var ${Entityname}Setup $${entityname}Setup */
        $${entityname}Setup = $this->${entityname}SetupFactory->create(['setup' => $setup]);

        $setup->startSetup();

        $${entityname}Setup->installEntities();
        $entities = $${entityname}Setup->getDefaultEntities();
        foreach ($entities as $entityName => $entity) {
            $${entityname}Setup->addEntityType($entityName, $entity);
        }

        $setup->endSetup();
    }
}
