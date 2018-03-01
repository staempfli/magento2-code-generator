/**
 * ${actionname}
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

/*jshint jquery:true*/
define([
    "jquery",
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($, alert) {
    "use strict";

    $.widget('${vendorname}_${modulename}.${actionname}ajax', {
        options: {
            ajaxUrl: null,
            elementToReplace: null,
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
                context: this,
                url: this.options.ajaxUrl,
                data: this.getDataForAjaxRequest(),
                cache: true,
                dataType: 'html',
                beforeSend: $.proxy(this.beforeSend, this),
                complete: $.proxy(this.complete, this),
                success: $.proxy(this.success, this),
                error: $.proxy(this.displayError, this, $.mage.__('Sorry, something went wrong.')),
            });

        },

        getDataForAjaxRequest: function() {
            var data = {};
            // data[dataCode] = dataValue;
            return data;
        },

        beforeSend: function () {
            $(this.options.waitLoadingContainer).show();
        },

        complete: function () {
            $(this.options.waitLoadingContainer).hide();
        },

        success: function (response) {
            $(this.options.elementToReplace).html(response);
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

    return $.${vendorname}_${modulename}.${actionname}ajax;
});