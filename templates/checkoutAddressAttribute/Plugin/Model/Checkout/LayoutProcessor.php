<?php
namespace ${Vendorname}\${Modulename}\Plugin\Model\Checkout;

class LayoutProcessor
{
    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     * @SuppressWarnings("unused")
     */
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, array  $jsLayout) //@codingStandardsIgnoreLine
    {
        foreach ($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
                 ['shippingAddress']['children']['shipping-address-fieldset']['children'] as $childname => &$child) {
            switch ($childname) {
                case '${fieldname}':
                    $child['sortOrder'] = 120;
                    break;
            }
        }

        return $jsLayout;
    }
}
