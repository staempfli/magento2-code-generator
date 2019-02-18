<?php
namespace ${Vendorname}\${Modulename}\Setup;

use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Quote\Setup\QuoteSetup;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Sales\Setup\SalesSetup;
use Magento\Sales\Setup\SalesSetupFactory;
use Magento\Config\Model\ResourceModel\Config;

/**
 * Upgrade Data script
 *
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;
    /**
     * @var QuoteSetupFactory
     */
    private $quoteSetupFactory;
    /**
     * @var SalesSetupFactory
     */
    private $salesSetupFactory;
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        QuoteSetupFactory $quoteSetupFactory,
        SalesSetupFactory $salesSetupFactory,
        Config $config
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
        $this->salesSetupFactory = $salesSetupFactory;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     * @codingStandardsIgnoreStart
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        $setup->startSetup();

        $this->addCustomerAddressAttribute($setup, '${fieldname}', '${fieldname}', 120, true, false);
        $this->createQuoteAndSalesAttributes($setup, '${fieldname}');
        $this->addAttributeInAddressTemplates();

        $setup->endSetup();
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param string $attributeCode
     * @param string $label
     * @param int $sortOrder
     * @param bool $showOnFrontend
     * @param bool $required
     * @param string $type
     * @param string $input
     * @param string|null $sourceModel
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function addCustomerAddressAttribute(
        ModuleDataSetupInterface $setup,
        string $attributeCode,
        string $label,
        int $sortOrder,
        bool $showOnFrontend = false,
        bool $required = false,
        string $type = 'varchar',
        string $input = 'text',
        $sourceModel = null
    ) {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute(
            'customer_address',
            $attributeCode,
            [
                'type' => $type,
                'label' => $label,
                'input' => $input,
                'required' => $required,
                'sort_order' => 0,
                'visible' => true,
                'user_defined' => 0,
                'system' => false,
                'is_used_in_grid' => false,
                'source' => $sourceModel,
            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', $attributeCode);
        $forms = ['adminhtml_customer'];
        if ($showOnFrontend) {
            $forms = ['adminhtml_customer_address', 'customer_register_address', 'customer_address_edit'];
        }
        $attribute->setData('used_in_forms', $forms);
        $attribute->save(); //@codingStandardsIgnoreLine
        $customerSetup->updateAttribute('customer_address', $attributeCode, 'sort_order', $sortOrder);
    }

    private function createQuoteAndSalesAttributes(
        ModuleDataSetupInterface $setup,
        string $attributeCode,
        string $type = 'varchar',
        string $length = '255'
    ) {
        /** @var QuoteSetup $quoteSetup */
        $quoteSetup = $this->quoteSetupFactory->create(['setup' => $setup]);
        /** @var SalesSetup $salesSetup */
        $salesSetup = $this->salesSetupFactory->create(['setup' => $setup]);

        $quoteSetup->addAttribute('quote_address', $attributeCode, ['type' => $type, 'length' => $length]);
        $salesSetup->addAttribute('order_address', $attributeCode, ['type' => $type, 'length' => $length]);

    }

    private function addAttributeInAddressTemplates()
    {
        $this->config->saveConfig(
                            'customer/address_templates/text',
                            <<<'TEMPLATE'
{{depend salutation}}{{var salutation}} {{/depend}}{{var firstname}} {{var lastname}}
{{depend company}}{{var company}}{{/depend}}
{{depend company_addition}}{{var company_addition}}{{/depend}}
{{if street1}}{{var street1}}
{{/if}}
{{depend street2}}{{var street2}}{{/depend}}
{{depend street3}}{{var street3}}{{/depend}}
{{depend street4}}{{var street4}}{{/depend}}
{{if postcode}}{{var postcode}} {{/if}}{{if city}}{{var city}}{{/if}}{{if region}}, {{var region}}{{/if}}
{{var country}}
Tel: {{var telephone_prefix}} {{var telephone}}
{{depend ${fieldname}}}{{var ${fieldname}}}{{/depend}}
TEMPLATE
                ,
                'default',
                0
            );
            $this->config->saveConfig(
                'customer/address_templates/html',
                <<<'TEMPLATE'
{{depend salutation}}{{var salutation}} {{/depend}}{{var firstname}} {{var lastname}}<br/>
{{depend company}}{{var company}}<br />{{/depend}}
{{depend company_addition}}{{var company_addition}}<br />{{/depend}}
{{if street1}}{{var street1}}<br />{{/if}}
{{depend street2}}{{var street2}}<br />{{/depend}}
{{depend street3}}{{var street3}}<br />{{/depend}}
{{depend street4}}{{var street4}}<br />{{/depend}}
{{if postcode}}{{var postcode}} {{/if}}{{if city}}{{var city}}{{/if}}{{if region}}, {{var region}}{{/if}}<br/>
{{var country}}<br/>
Tel: {{var telephone_prefix}} {{var telephone}}
{{depend ${fieldname}}}<br/>{{var ${fieldname}}}{{/depend}}
TEMPLATE
                ,
                'default',
                0
            );
            //@codingStandardsIgnoreStart
            $this->config->saveConfig(
                'customer/address_templates/oneline',
                <<<'TEMPLATE'
{{depend salutation}}{{var salutation}} {{/depend}}{{var firstname}} {{var lastname}}{{depend company}}, {{var company}}<br />{{/depend}}{{depend company_addition}}, {{var company_addition}}{{/depend}}{{if street1}}, {{var street1}}{{/if}}{{depend street2}}, {{var street2}}{{/depend}}{{depend street3}}, {{var street3}}{{/depend}}{{depend street4}}, {{var street4}}{{/depend}}, {{if postcode}}{{var postcode}} {{/if}}{{if city}}{{var city}}{{/if}}{{if region}}, {{var region}}{{/if}}, {{var country}}
TEMPLATE
                ,
                'default',
                0
            );
            //@codingStandardsIgnoreEnd
            $this->config->saveConfig(
                'customer/address_templates/pdf',
                <<<'TEMPLATE'
{{depend salutation}}{{var salutation}} {{/depend}}{{var firstname}} {{var lastname}}|
{{depend company}}{{var company}}|{{/depend}}
{{depend company_addition}}{{var company_addition}}|{{/depend}}
{{if street1}}{{var street1}}|{{/if}}
{{depend street2}}{{var street2}}|{{/depend}}
{{depend street3}}{{var street3}}|{{/depend}}
{{depend street4}}{{var street4}}|{{/depend}}
{{if postcode}}{{var postcode}} {{/if}}{{if city}}{{var city}}{{/if}}{{if region}}, {{var region}}{{/if}}|
{{var country}}|
Tel: {{var telephone_prefix}} {{var telephone}}
{{depend ${fieldname}}}{{var ${fieldname}}}{{/depend}}
TEMPLATE
                ,
                'default',
                0
            );
    }

}
