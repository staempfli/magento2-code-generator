/**
 * ${actionname}
 *
 * @copyright Copyright (c) ${commentsYear} ${CommentsCompanyName}
 * @author    ${commentsUserEmail}
 */

/*jshint jquery:true*/
define([
    "jquery",
    "jquery/ui"
], function ($) {
    "use strict";

    $.widget('${vendorname}_${modulename}.${actionname}ajax', {
        options: {
            ajaxUrl: null,
            classElementTriggerAjax: null,
            idElementToReplace: null,
            waitLoadingContainer: null
        },

        /**
         * Bind a click handler on the widget's element.
         * @private
         */
        _create: function() {
            $(this.options.classElementTriggerAjax).on('click', $.proxy(this._clickAction, this));
        },

        /**
         * Init object
         * @private
         */
        _init: function () {
            // Do something if needed
        },

        /**
         * Click action function
         * @private
         * @param event - {Object} - Click event.
         */
        _clickAction: function(event) {

        }

        /**
         * Click action function
         * @private
         * @param event - {Object} - Click event.
         */
        _clickAction: function(event) {
            if ($(this.options.waitLoadingContainer).is(":visible")) {
                return false;
            }
            // Do something with element clicked $(event.target)

            $.ajax({
                context: this,
                url: this.options.ajaxUrl,
                data: this._getDataForAjaxRequest(),
                cache: true,
                dataType: 'html',
                beforeSend: this._ajaxBeforeSend,
                complete: this._ajaxComplete,
                success: this._ajaxSuccess,
                error: this._ajaxError
            });

        },

        /**
         * Get data for Ajax request
         *
         * @returns {{}}
         * @private
         */
        _getDataForAjaxRequest: function() {
            var data = {};

            // data[dataCode] = dataValue;
            return data;
        },

        /**
         * show ajax loader
         */
        _ajaxBeforeSend: function () {;
            $(this.options.waitLoadingContainer).show();
        },

        /**
         * hide ajax loader
         */
        _ajaxComplete: function () {
            $(this.options.waitLoadingContainer).hide();
        },

        /**
         * Ajax Success Action
         */
        _ajaxSuccess: function (response) {
            $(this.options.idElementToReplace).html(response);
        },

        /**
         * Ajax Error Action
         */
        _ajaxError: function () {
            alert({
                content: $.mage.__('Sorry, something went wrong.')
            });
        }
    });

    return $.${vendorname}_${modulename}.${actionname}ajax;
});