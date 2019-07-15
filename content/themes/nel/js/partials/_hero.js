(function ($, document, window, undefined) {

    var $hero = $('.hero'),
        $window = $(window)

    function setHeroSize () {
        var wHeight = $window.height(),
            hMaxHeight = wHeight - 300,
            hMinHeight = 600

        if (hMaxHeight < hMinHeight) {
            hMaxHeight = hMinHeight
        }

        $hero.css({ maxHeight: hMaxHeight })
    }

    if ($hero.length) {
        $window.on('resize', window.nel.utils.throttle(setHeroSize, 100))
        setHeroSize()
    }

})(jQuery, document, window)