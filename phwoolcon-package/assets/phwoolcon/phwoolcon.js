/*! phwoolcon v1.0-dev | Apache-2.0 */
!function (w) {
    var options = Object.assign({
        cookies: {
            domain: null,
            path: "/"
        },
        debug: false
    }, w.phwoolconOptions || {});
    w.$p = {
        options: options,
        cookie: function (name, value, options) {
            return Cookies.set(name, value, Object.assign({}, w.$p.options.cookies, options));
        },
        log: function () {
            if (this.options.debug) {
                console.log.apply(w, arguments);
            }
        },
        trace: function () {
            if (this.options.debug) {
                (console.trace || console.log).apply(w, arguments);
            }
        },
        jsonToFormData: function (json) {
            var formData = new FormData();
            Object.keys(json).forEach(function (key) {
                formData.append(key, json[key])
            });
            return formData;
        }
    };
}(window);
