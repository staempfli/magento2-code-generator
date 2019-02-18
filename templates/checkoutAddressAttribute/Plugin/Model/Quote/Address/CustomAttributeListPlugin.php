<?php
/**
 * CustomAttributeListPlugin
 *
 * @copyright Copyright © 2019 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace ${Vendorname}\${Modulename}\Plugin\Model\Quote\Address;

class CustomAttributeListPlugin
{
    /**
     * @var \Magento\Customer\Api\AddressMetadataInterface
     */
    private $addressMetadata;

    public function __construct(\Magento\Customer\Api\AddressMetadataInterface $addressMetadata)
    {
        $this->addressMetadata = $addressMetadata;
    }

    /**
     * @param \Magento\Quote\Model\Quote\Address\CustomAttributeListInterface $subject
     * @param $result
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings("unused")
     */
    public function afterGetAttributes(\Magento\Quote\Model\Quote\Address\CustomAttributeListInterface $subject, $result) //@codingStandardsIgnoreLine
    {
        $customAttributes = [];
        $customAttributesMetadata = $this->addressMetadata->getCustomAttributesMetadata(\Magento\Quote\Api\Data\AddressInterface::class);
        foreach ($customAttributesMetadata as $attributeMetadata) {
            $attributeCode = $attributeMetadata->getAttributeCode();
            $customAttributes[$attributeCode] = true;
        }

        return array_merge($result, $customAttributes);
    }
}