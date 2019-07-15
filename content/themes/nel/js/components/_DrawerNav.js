(function ($) {
    $('[data-scope="DrawerNav"]').each(function () {
        var $nav = $(this),
            $page = $('#page'),
            menu_is_open = false,
            menu_is_animating = false,
            $cur_nav,
            cur_id

        function closeOnClickOutside (event) {
            if (event.target.nodeName !== 'A') {
                closeMenu()
            }
        }

        function openMenu (id) {
            if (menu_is_animating) {
                return
            }

            // Hide current open nav
            if ($cur_nav) {
                $cur_nav.hide()
            }

            // Show selected nav
            $cur_nav = $('#DrawerNav-' + id).show()
            cur_id = id

            menu_is_animating = true
            menu_is_open = true
            $nav.show()
            $page.addClass('is-animating')

            setTimeout(function () {
                $page.css({
                    transform: 'translateY(' + $cur_nav.height() + 'px)'
                })
            }, 16)

            setTimeout(function () {
                $page
                    .removeClass('is-animating')
                    .on('click', closeOnClickOutside)
                    .css({ transform: '' })
                $nav.css({ position: 'relative' })
                menu_is_animating = false
            }, 266)
        }

        function closeMenu (id) {
            if (menu_is_animating) {
                return
            }

            menu_is_animating = true
            menu_is_open = false
            $page.off('click', closeOnClickOutside).addClass('is-animating')

            setTimeout(function () {
                $page.css({
                    transform: 'translateY(-' + $nav.children().height() + 'px)'
                })
            }, 16)

            setTimeout(function () {
                $page.css({ transform: '' }).removeClass('is-animating')
                $nav.css({ position: '' }).hide()
                menu_is_animating = false

                // Hide current open nav
                if ($cur_nav) {
                    $cur_nav.hide()
                    $cur_nav = undefined
                    cur_id = undefined
                }
            }, 266)
        }

        function toggleMenu (id) {
            if (!menu_is_open || id !== cur_id) {
                openMenu(id)
            } else {
                closeMenu(id)
            }
        }

        $('.DrawerNavToggle').on('click', function (event) {
            var id = $(this)
                .find('[data-drawer-id]')
                .data('drawer-id')
            if (window.Foundation.MediaQuery.atLeast('large')) {
                toggleMenu(id)
                event.preventDefault()
            }
        })
    })
})(jQuery)
