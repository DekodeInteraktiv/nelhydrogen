(function ($, document, window, undefined) {
    //  aspect content min height
    $.fn.aspectMinHeight = function () {
        var $panels = this

        function setMinHeight () {
            $panels.each(function () {
                var $this = $(this),
                    $inner = $this.find('.section__content'),
                    min_height = $inner.outerHeight()

                $this.css({ 'min-height': min_height })
            })
        }

        $(window).on('resize', window.nel.utils.debounce(setMinHeight, 100))
        setMinHeight()
    }

    $('.aspect').aspectMinHeight()
})(jQuery, document, window)
