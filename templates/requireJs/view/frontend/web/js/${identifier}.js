/**
 * ${identifier}
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

/*jshint jquery:true*/
define([
    "jquery",
    "jquery/ui",
    'mage/translate'
], function ($) {
    "use strict";

    $.widget('${vendorname}_${modulename}.${identifier}', {
        options: {
            // optionName: value
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
            // Do something with element clicked $(event.target)
        }
    });

    return $.${vendorname}_${modulename}.${identifier};
});