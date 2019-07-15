(function name ($, SmoothScroll) {
    var scroll = new SmoothScroll(false, {
        speed: 1000
    })

    $('[data-component="ScrollIndicator"]').each(function () {
        var $this = $(this)

        $this.on('click', function () {
            var scrollOffset = $this.offset().top + $this.height() + 10
            scroll.animateScroll(scrollOffset)
        })
    })
})(jQuery, window.SmoothScroll)
