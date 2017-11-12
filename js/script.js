window.onload = function () {

    (function () {
        var lastTime = 0;
        var vendors = ['ms', 'moz', 'webkit', 'o'];
        for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
            window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
            window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] ||
                window[vendors[x] + 'CancelRequestAnimationFrame'];
        }

        if (!window.requestAnimationFrame)
            window.requestAnimationFrame = function (callback, element) {
                var currTime = new Date().getTime();
                var timeToCall = Math.max(0, 16 - (currTime - lastTime));
                var id = window.setTimeout(function () {
                        callback(currTime + timeToCall);
                    },
                    timeToCall);
                lastTime = currTime + timeToCall;
                return id;
            };

        if (!window.cancelAnimationFrame)
            window.cancelAnimationFrame = function (id) {
                clearTimeout(id);
            };
    }());

    if (typeof window.orientation !== 'undefined') {
        var tagPhone = document.getElementById('telephone');
        var phone = tagPhone.innerHTML;
        tagPhone.innerHTML = '<a href="tel:' + phone.replace(/[^0-9+]/g, '') + '">' + phone + '</a>';
    }

    var butScrollUp = document.getElementById('scrollup');

    window.onscroll = function () {
        if (window.pageYOffset > 0) {
            butScrollUp.style.display = 'block';
        } else {
            butScrollUp.style.display = 'none';
        }
    };

    butScrollUp.onclick = function () {
        up();
    };

    function up() {
        var top = window.pageYOffset;
        window.scrollBy(0, ((top + 100) / -25));
        if (top > 0) {
            requestAnimationFrame(up);
        }
    };
};
