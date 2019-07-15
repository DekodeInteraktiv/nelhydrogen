(function ($, document, window, undefined) {

    $.fn.topbutton = function () {

        var $window = $(window),
            $document = $(document)

        return this.each(function () {

            var $btn = $(this)

            function updateScrollPosition () {

                var st = $document.scrollTop(),
                    toggleclass = (st > 150)

                $btn.toggleClass('visible', toggleclass)

            }

            $window.on('scroll', window.nel.utils.throttle(updateScrollPosition, 100))

            $btn.on('click', function (event) {
                // will fire twice - but it's not a big problem with the .removeClass function
                $('body,html').animate({ scrollTop: 0 }, {
                    duration: 300, complete: function () {
                        $btn.removeClass('visible')
                    }
                })
                event.preventDefault()
            })

        })

    }

})(jQuery, document, window)