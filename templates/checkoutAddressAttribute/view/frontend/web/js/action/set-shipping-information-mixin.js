define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';

    return function (setShippingInformationAction) {

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();
            if (shippingAddress.customAttributes === undefined) {
                shippingAddress.customAttributes = {};
            }
            
            if (shippingAddress.customAttributes['${fieldname}'] instanceof Object) {
                shippingAddress.customAttributes['${fieldname}'] = shippingAddress.customAttributes['${fieldname}'].value;
            }

            return originalAction();
        });
    };
});