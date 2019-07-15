(function ($, document, window, undefined) {
    $.fn.mobilemenu = function () {
        var $body = $('body')

        return this.each(function () {
            var $button = $(this),
                $menu = $($button.data('menu')),
                is_open = false,
                open_class = 'mm-open',
                $overlay = $($button.data('overlay')),
                duration = 250,
                show_timer,
                hide_timer

            function openMenu () {
                is_open = true

                if (hide_timer) {
                    clearTimeout(hide_timer)
                }

                // add animation class
                $overlay.show().addClass('is-animating')
                $menu.show().addClass('is-animating')

                // show elements
                setTimeout(function () {
                    $menu.addClass(open_class)
                    $overlay.addClass(open_class)
                }, 16)

                // remove anim class
                show_timer = setTimeout(function () {
                    $menu.removeClass('is-animating')
                    $overlay.removeClass('is-animating')
                    $('html').css({ overflow: 'hidden' })
                }, duration + 16)

                $button.addClass(open_class)
                $body.addClass(open_class)
            }

            function closeMenu () {
                is_open = false

                if (show_timer) {
                    clearTimeout(show_timer)
                }

                $overlay.addClass('is-animating')
                $menu.addClass('is-animating')

                // animate out
                setTimeout(function () {
                    $menu.removeClass(open_class)
                    $overlay.removeClass(open_class)
                }, 16)

                // remove anim class
                hide_timer = setTimeout(function () {
                    $menu.removeClass('is-animating').css({ display: '' })
                    $overlay.removeClass('is-animating').css({ display: '' })
                    $('html').css({ overflow: '' })
                }, duration + 16)

                $button.removeClass(open_class)
                $body.removeClass(open_class)
            }

            function toggleMenu () {
                if (is_open) {
                    closeMenu()
                } else {
                    openMenu()
                }
            }

            $button.on('click', function (event) {
                toggleMenu()
                event.preventDefault()
            })

            $overlay.on('click', function () {
                closeMenu()
            })

            $button.on('close', closeMenu)
        })
    }

    $('.mobile-menu-toggle').mobilemenu()

    // $('.menu-item-has-children')

    var hidetime, hide_await

    $('.menu-item-has-children')
        .not('.DrawerNavToggle')
        .on('mouseenter', function () {
            if (window.Foundation.MediaQuery.atLeast('large')) {
                if (hide_await) {
                    clearTimeout(hide_await)
                }
                if (hidetime) {
                    clearTimeout(hidetime)
                }
                $('.menu-overlay')
                    .addClass('is-animating')
                    .show()

                setTimeout(function () {
                    $('.menu-overlay').addClass('mm-open')
                }, 16)
            }
        })
        .on('mouseleave', function () {
            if (window.Foundation.MediaQuery.atLeast('large')) {
                hide_await = setTimeout(function () {
                    $('.menu-overlay').removeClass('mm-open')
                    hidetime = setTimeout(function () {
                        $('.menu-overlay')
                            .removeClass('.is-animating')
                            .hide()
                    }, 300)
                }, 500)
            }
        })
        .on('click', 'a', function (event) {
            var $this = $(this),
                main_href = $this
                    .closest('.menu-item-has-children')
                    .children('a')
                    .first()
                    .attr('href'),
                href = $(this).attr('href')

            $('.mobile-menu-toggle').trigger('close')

            if (main_href !== href && main_href !== window.location.href) {
                if (href.indexOf('#') === 0) {
                    // window.alert(main_href+href);

                    window.location.href = main_href + href
                    event.preventDefault()
                }
            }
        })
})(jQuery, document, window)
