/*! phwoolcon v1.0-dev | Apache-2.0 */
!function (w, $) {
    var options = $.extend({
        cookies: {
            domain: null,
            path: "/"
        },
        debug: false
    }, w.phwoolconOptions);
    w.$p = {
        options: options,
        cookie: function (name, value, options) {
            return $.cookie(name, value, $.extend({}, w.$p.options.cookies, options));
        },
        log: function () {
            if (this.options.debug) {
                console.log.apply(w, arguments);
            }
        }
    };
}(window, jQuery);
