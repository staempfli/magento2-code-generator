var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                '${Vendorname}_${Modulename}/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                '${Vendorname}_${Modulename}/js/action/place-order-mixin': true
            },
            'Magento_Checkout/js/model/new-customer-address': {
                '${Vendorname}_${Modulename}/js/model/new-customer-address-mixin': true
            }
        }
    }
};