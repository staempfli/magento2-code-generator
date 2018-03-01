/**
 * ${actionname}
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

/*jshint jquery:true*/
define([
    "jquery",
    'mage/url',
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($, url, alert) {
    "use strict";

    $.widget('${vendorname}_${modulename}.${actionname}', {
        options: {
            waitLoadingContainer: null
        },

        /**
         * Bind a click handler on the widget's element.
         * @private
         */
        _create: function() {
            this.element.on('click', $.proxy(this.clickAction, this));
        },

        /**
         * Init object
         * @private
         */
        _init: function () {
            // Do something if needed
        },

        clickAction: function(event) {
            if ($(this.options.waitLoadingContainer).is(":visible")) {
                return false;
            }
            // Do something with element clicked $(event.target)

            $.ajax({
                url:  url.build('/rest/V1/${modulename}/${actionname}'),
                data: this.dataForApiRequest(),
                cache: false,
                contentType: 'application/json',
                type: 'PUT',
                beforeSend: $.proxy(this.beforeSend, this),
                complete: $.proxy(this.complete, this),
                success: $.proxy(this.success, this),
                error: $.proxy(this.displayError, this, $.mage.__('Sorry, something went wrong.')),
            });

        },

        dataForApiRequest: function() {
            var data = {};
            // data[dataCode] = dataValue;
            return JSON.stringify(data);
        },

        beforeSend: function () {
            $(this.options.waitLoadingContainer).show();
        },

        complete: function () {
            $(this.options.waitLoadingContainer).hide();
        },

        success: function (response) {
            var result = JSON.parse(response);
            if (result.success) {
                // Do something with result.success api response
                alert('Success: ' + result.success);
            }
        },

        displayError: function (message) {
            alert({
                title: $.mage.__('An error occurred'),
                content: message,
                actions: {
                    always: function(){}
                }
            });
        }
    });

    return $.${vendorname}_${modulename}.${actionname};
});