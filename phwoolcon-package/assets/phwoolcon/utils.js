HTMLElement.prototype.addClass = function (addMe) {
    if (this.hasClass(addMe)) {
        return;
    }
    this.className = this.className + " " + addMe;
};

HTMLElement.prototype.removeClass = function (removeMe) {
    var newClassName = "", i, classes = this.className.split(/\s+/);
    for (i = 0; i < classes.length; i++) {
        if (classes[i] !== removeMe) {
            newClassName += classes[i] + " ";
        }
    }
    this.className = newClassName;
};

HTMLElement.prototype.hasClass = function (hasMe) {
    var classes = this.className.split(/\s+/), i;
    for (i = 0; i < classes.length; i++) {
        if (classes[i] === hasMe) {
            return true;
        }
    }
    return false;
};

HTMLElement.prototype.toggleClass = function (toggleMe) {
    if (this.hasClass(toggleMe)) {
        this.removeClass(toggleMe);
    } else {
        this.addClass(toggleMe);
    }
};

document.on = function (eventName, selector, handler) {
    document.addEventListener(eventName, function (event) {
        for (var target = event.target || event.srcElement; target && target !== this; target = target.parentNode) {
            // loop parent nodes from the target to the delegation node
            if (target.matches(selector)) {
                handler.call(target, event);
                break;
            }
        }
    }, false);
};
