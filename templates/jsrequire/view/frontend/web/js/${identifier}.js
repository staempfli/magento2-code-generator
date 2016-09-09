/**
 * ${identifier}
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */

/*jshint jquery:true*/
define([
    "jquery",
    "jquery/ui"
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
            this.element.on('click', $.proxy(this._clickAction, this));
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
            // Do something with element clicked $(event.target)
        }
    });

    return $.${vendorname}_${modulename}.${identifier};
});