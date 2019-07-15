(function ($, document, window, undefined) {

    // currently only supports video

    $.fn.containerfit = function () {

        return this.each(function () {

            var $element = $(this),
                element = this,
                $container = $element.parent(),
                type = this.tagName.toLowerCase()

            function fitToContainer () {

                var wrapperHeight = $container.height(),
                    wrapperWidth = $container.width(),

                    elementWidth,
                    elementHeight

                if (type === 'video') {

                    elementWidth = element.videoHeight
                    elementHeight = element.videoWidth

                }

                if (wrapperWidth / elementWidth > wrapperHeight / elementHeight) {
                    $element.css({
                        width: wrapperWidth + 2,
                        height: 'auto'
                    })
                } else {
                    $element.css({
                        width: 'auto',
                        height: wrapperHeight + 2
                    })
                }

            }

            $(window).on('resize', window.nel.utils.debounce(fitToContainer, 100))
            fitToContainer()

        })

    }

})(jQuery, document, window)