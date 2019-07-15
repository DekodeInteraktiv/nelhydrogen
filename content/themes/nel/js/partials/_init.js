(function ($, document, window, undefined) {
    $(document).foundation()

    // https://github.com/michalsnik/aos
    window.AOS.init({
        duration: 200,
        disable: function () {
            return window.Foundation.MediaQuery.current === 'small'
        }
    })

    /*
    https://github.com/cferdinandi/smooth-scroll
    */
    var SmoothScroll = window.SmoothScroll
    var SC = new SmoothScroll('.scrollto', {
        speed: 500
    })

    /*
      *
      Homepage galaxy
      *
      */

    $('.galaxy-home').galaxy({
        speed: 5,
        color: 0xaf00ff
    })

    $('.js-galaxy-404').galaxy({
        speed: 2,
        color: 0xaf00ff
    })

    /*
      *
      Modals
      *
      */

    /*
      Modals - helpers
      */

    // add global close button
    $(document).on('click', '.modal-close', function (event) {
        $.magnificPopup.instance.close()
        event.preventDefault()
    })

    // add global form reload button
    $(document).on('gform_confirmation_loaded', function (
        event,
        form_id,
        undefined
    ) {
        $('a.form-reload').on('click', function (event) {
            document.location.reload()
            event.preventDefault()
        })
    })

    // add division to form on click
    var division = ''
    $('[data-division]').on('click', function () {
        var $this = $(this),
            key = $this.data('division')
        division = key
        return true
    })

    /*
      Modals - init
    */

    $('.ajax-popup-link').magnificPopup({
        type: 'ajax',
        mainClass: 'mfp-fade',
        removalDelay: 300,
        closeBtnInside: true,
        gallery: {
            enabled: false
        },
        callbacks: {
            parseAjax: function (mfpResponse) {
                var $ajaxContent = $(mfpResponse.data).find('.js-mfp-content')
                if ($ajaxContent.length) {
                    mfpResponse.data = $ajaxContent
                }
            }
        }
    })

    $('.open-popup-link-person').magnificPopup({
        type: 'inline',
        mainClass: 'mfp-fade',
        removalDelay: 300,
        closeBtnInside: true,
        gallery: {
            enabled: false
        }
    })

    $('.open-popup-link-video').magnificPopup({
        type: 'inline',
        mainClass: 'mfp-fade mfp-html5-video',
        removalDelay: 300,
        closeBtnInside: false,
        callbacks: {
            open: function () {
                var $video = this.content.find('video')
                if ($video.length) {
                    $video[0].play()
                }
            },
            close: function () {
                var $video = this.content.find('video')
                if ($video.length) {
                    $video[0].pause()
                }
            }
        }
    })

    $('.open-popup-link-inline').magnificPopup({
        type: 'inline',
        mainClass: 'mfp-fade',
        removalDelay: 300,
        closeBtnInside: true
    })

    $('.open-popup-link').magnificPopup({
        type: 'inline',
        mainClass: 'mfp-fade',
        removalDelay: 300,
        closeBtnInside: true,
        callbacks: {
            // markupParse: function(template, values, item)
            // markupParse: function(template, values, item) {
            //   console.log('markup parse', this, template, values, item);
            // },
            open: function () {
                var $content = this.content,
                    $form = $content.find('.gform_wrapper')

                if (division !== '') {
                    $form
                        .find('.division-select')
                        .find('select')
                        .val(division)
                        .trigger('change')
                }

                // remove validation errors on open
                $form.find('.validation_error').remove()
                $form
                    .find('.gfield_error')
                    .find('.validation_message')
                    .remove()
                $form.find('.gfield_error').removeClass('gfield_error')
            }
        }
    })

    $('.section-nav').each(function (event) {
        var $main = $(this),
            $list = $main.find('.section-nav__list')

        function updateScrollPos () {
            if ($list[0].scrollWidth - $list.scrollLeft() === $list.outerWidth()) {
                $main.addClass('is-right')
                return
            } else if ($list.scrollLeft() === 0) {
                $main.addClass('is-left')
                return
            }
            $main.removeClass('is-left')
            $main.removeClass('is-right')
        }

        $list.on('scroll', updateScrollPos).trigger('scroll')
        $(window).on('resize', updateScrollPos)
    })

    $('a.open-popup-link-search').magnificPopup({
        type: 'inline',
        mainClass: 'mfp-fade mfp-search',
        removalDelay: 300,
        closeBtnInside: false,
        focus: 'input[type=search]'
    })

    $('.btn-top').topbutton()

    $('.button-nav').each(function () {
        var $this = $(this),
            $toggler = $this.find('.button-nav__toggle'),
            $list = $this.find('.button-nav__list')
        $toggler.on('click', function () {
            $this.toggleClass('is-open')
        })
        $list.on('click', function () {
            $this.removeClass('is-open')
        })
    })

    $('.related-products-slick').slick({
        infinite: false,
        slidesToShow: 2,
        slidesToScroll: 2,
        accessibility: false,
        mobileFirst: true,
        arrows: false,
        dots: true,
        swipeToSlide: true,
        responsive: [
            // medium
            {
                breakpoint: 640,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            // large
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            }
            // xlarge
            // {
            //   breakpoint: 1200,
            //   settings: {
            //     slidesToShow: 1,
            //     slidesToScroll: 1
            //   }
            // }
        ]
    })
})(jQuery, document, window)
