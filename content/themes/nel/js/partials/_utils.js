window.nel = {
    utils: {
        throttle: function (callback, limit) {
            var wait = false
            return function () {
                if (!wait) {
                    callback.call()
                    wait = true
                    setTimeout(function () {
                        wait = false
                    }, limit)
                }
            }
        },

        debounce: function (func, threshold, execAsap) {
            var timeout

            return function debounced () {
                var obj = this,
                    args = arguments

                function delayed () {
                    if (!execAsap) {
                        func.apply(obj, args)
                    }
                    timeout = null
                }

                if (timeout) {
                    clearTimeout(timeout)
                } else if (execAsap) {
                    func.apply(obj, args)
                }

                timeout = setTimeout(delayed, threshold || 100)
            }
        }
    }
}

Object.defineProperty(String.prototype, 'removeCDATA', {
    value: function () {
        'use strict'
        return this.replace('<![CDATA[', '').replace(']]>', '')
    }
})
