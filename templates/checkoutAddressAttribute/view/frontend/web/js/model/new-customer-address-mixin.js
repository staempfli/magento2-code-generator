define([
    'jquery',
    'mage/utils/wrapper',
], function ($, wrapper) {
    'use strict';

    return function (setShippingInformationAction) {
        
        return wrapper.wrap(setShippingInformationAction, function (originalAction, addressData) {

            if (addressData['custom_attributes'] === undefined) {
                addressData['custom_attributes'] = {};
            }

            if(addressData.${fieldname} != undefined) {
                addressData['custom_attributes']['${fieldname}'] = {
                    'attribute_code': '${fieldname}',
                    'value': addressData.${fieldname}
                };
            }

            return originalAction(addressData);
        });
    };
});