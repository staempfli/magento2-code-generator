<?php
/**
 * EditPlugin
 *
 * @copyright Copyright © 2019 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace ${Vendorname}\${Modulename}\Plugin\Block\Address;


class EditPlugin
{
    public function afterGetNameBlockHtml(\Magento\Customer\Block\Address\Edit $editAddressBlock, $nameBlockHtml)
    {
        $customAttributesBlock = $editAddressBlock->getLayout()
            ->createBlock(\${Vendorname}\${Modulename}\Block\Widget\CustomAttributes::class)
            ->setData('address', $editAddressBlock->getAddress());

        return $nameBlockHtml . $customAttributesBlock->toHtml() ;
    }
}