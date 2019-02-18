define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';

    return function (placeOrderAction) {

        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, messageContainer) {
            var billingAddress = quote.billingAddress();
            if (billingAddress.customAttributes === undefined) {
                billingAddress.customAttributes = {};
            }

            if (billingAddress.customAttributes['${fieldname}'] instanceof Object) {
                billingAddress.customAttributes['${fieldname}'] = billingAddress.customAttributes['${fieldname}'].value;
            }

            return originalAction(paymentData, messageContainer);
        });
    };
});

