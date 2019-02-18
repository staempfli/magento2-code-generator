<?php
/**
 * CustomAttributes
 *
 * @copyright Copyright © 2019 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace ${Vendorname}\${Modulename}\Block\Widget;

use Magento\Framework\View\Element\Template;

class CustomAttributes extends Template
{
    /**
     * @var string $_template
     */
    protected $_template = "${Vendorname}_${Modulename}::custom-attributes.phtml";
    /**
     * @var \Magento\Framework\Api\AddressMetadataInterface
     */
    private $addressMetadata;

    public function __construct(
        \Magento\Customer\Api\AddressMetadataInterface $addressMetadata,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->addressMetadata = $addressMetadata;
    }

    public function getCustomAttributes()
    {
        $customAttributes = [];

        /* @var \Magento\Customer\Api\Data\AddressInterface $address */
        $address = $this->getData('address');
        $customAttributesMetadata = $this->addressMetadata->getCustomAttributesMetadata(get_class($address));

        foreach ($customAttributesMetadata as $attributeMetadata) {
            $attributeCode = $attributeMetadata->getAttributeCode();
            $customAttributes[$attributeCode] = $address->getCustomAttribute($attributeCode) ? $address->getCustomAttribute($attributeCode)->getValue() : '';
        }

        return $customAttributes;
    }
}