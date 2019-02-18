<?php
namespace ${Vendorname}\${Modulename}\Plugin\Model;

use Magento\Quote\Model\Quote\Address as QuoteAddress;
use Magento\Quote\Model\Quote\Address\ToOrderAddress;
use Magento\Sales\Model\Order\Address as OrderAddress;

class QuoteAddressToOrderAddressPlugin
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
     * @param ToOrderAddress $toOrderAddress
     * @param \Closure $proceed
     * @param QuoteAddress $quoteAddress
     * @param array $data
     * @return OrderAddress
     * @throws \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings("unused")
     */
    public function aroundConvert(ToOrderAddress $toOrderAddress, \Closure $proceed, QuoteAddress $quoteAddress, $data = []) //@codingStandardsIgnoreLine
    {
        /** @var OrderAddress $orderAddress */
        $orderAddress = $proceed($quoteAddress, $data);

        $customAttributesMetadata = $this->addressMetadata->getCustomAttributesMetadata(get_class($quoteAddress));
        foreach ($customAttributesMetadata as $attributeMetadata) {
            $attributeCode = $attributeMetadata->getAttributeCode();
            $value = $quoteAddress->getData($attributeCode);
            if (null !== $value) {
                $orderAddress->setData($attributeCode, $value);
            }
        }
        return $orderAddress;
    }
}
