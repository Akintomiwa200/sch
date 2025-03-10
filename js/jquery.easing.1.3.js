/* jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 * Terms of use: http://www.gnu.org/licenses/lgpl.html
 *
 * Copyright (c) 2015, George Smith (http://gsgd.co.uk)
 * All rights reserved.
 */
(function ($) {
    $.easing.jswing = $.easing.swing;
    $.extend($.easing, {
        def: "easeOutQuad",
        swing: function (x, t, b, c, d) {
            return $.easing["easeOutQuad"](x, t, b, c, d);
        },
        easeOutQuad: function (x, t, b, c, d) {
            return -c * (t /= d) * (t - 2) + b;
        },
        // Add other easing functions here
    });
})(jQuery);
