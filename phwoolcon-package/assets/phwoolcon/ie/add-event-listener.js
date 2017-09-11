/**
 * addEventListener polyfill 1.0 / Eirik Backer / MIT Licence
 * @see https://gist.github.com/eirikbacker/2864711
 */
window.addEventListener || (function (w, d) {
    function docHijack(p) {
        var old = d[p];
        d[p] = function (v) {
            return addListen(old(v))
        }
    }

    function addEvent(on, fn, self) {
        return (self = this).attachEvent('on' + on, function (e) {
            e = e || w.event;
            e.preventDefault = e.preventDefault || function () {
                e.returnValue = false;
            };
            e.stopPropagation = e.stopPropagation || function () {
                e.cancelBubble = true;
            };
            fn.call(self, e);
        });
    }

    function addListen(obj, i) {
        if (i = obj.length) {
            while (i--) {
                obj[i].addEventListener = addEvent;
            }
        }
        else {
            obj.addEventListener = addEvent;
        }
        return obj;
    }

    addListen([d, w]);
    //IE8
    if ('Element' in w) {
        w.Element.prototype.addEventListener = addEvent;
    } //IE < 8
    else {
        // Make sure we also init at domReady
        d.attachEvent('onreadystatechange', function () {
            addListen(d.all)
        });
        docHijack('getElementsByTagName');
        docHijack('getElementById');
        docHijack('createElement');
        addListen(d.all);
    }
})(window, document);
