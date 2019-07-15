(function ($, document, window, undefined) {
    $.fn.panelizer = function (options) {
        var $window = $(window),
            $document = $(document),
            settings = {
                onPanelChange: function () {},
                onProgress: function () {},
                onPanelProgress: function () {}
            }

        $.extend(settings, options)

        return this.each(function (parent_index) {
            var $body = $('body'),
                $page = $('html,body'),
                $el = $(this).addClass('plz-wrap-' + parent_index),
                $panels = $el.find('.section'),
                $nav = $el.find('.plz-nav'),
                $progress = $el.find('.plz-progress'),
                $progress_bar = $el.find('.plz-progress-bar'),
                w_height,
                current_panel_index = -1,
                prevent_menu_item_shift = false,
                preventUpdateScroll = false,
                is_current_panelizer = false,
                $current_panel

            // globals = {
            // 	$curSlide: undefined,
            // 	$curNavItem: undefined,
            // 	curSlidePosition: 0
            // }

            // a boolean to test if the current $el is in view

            /*
                  Create navigation
                  */

            function createNav () {
                var build = ''
                $panels.each(function (i) {
                    build +=
                        '<li class="plz-nav__item"><div class="plz-nav__label">' +
                        $(this).data('nav-title') +
                        '</div><button><span>' +
                        (i + 1) +
                        '</span></button></li>'
                })
                $nav.html('<ul class="inner">' + build + '</ul>')

                $nav
                    .on('mouseenter', function () {
                        $(this).addClass('hover-state')
                    })
                    .on('mouseleave', function () {
                        $(this).removeClass('hover-state')
                    })
            }

            createNav()

            function setPanelSize () {
                w_height = $window.height()
                //$panels.css({'min-height': w_height});

                if ($progress.length) {
                    $progress.height(w_height)
                }

                $nav.height(w_height)

                // if (is_init) {
                // 	initSlideHash();
                // }else{
                // 	updateScrollPosition();
                // }

                updateScrollPosition()
            }

            function getCurrentPanelIndex () {
                var scrollTop = $document.scrollTop(),
                    wtop = scrollTop + w_height / 2

                // find current slide index based on scroll
                for (var i = 0; i < $panels.length; i++) {
                    var $panel = $($panels[i]),
                        panelTop = $panel.offset().top,
                        panelHeight = $panel.outerHeight(),
                        panelBottom = panelTop + panelHeight

                    // check if panel top is above center and panel bottom is below center
                    if (panelTop < wtop && panelBottom > wtop) {
                        //percentage from when panel top is above center and panel bottom is below center
                        //var panelPercentage = decimalRound( (wtop - panelTop) / panelHeight );
                        //$nav.find('li').eq(i).find('.label').text( Math.round(panelPercentage*100)+'%');

                        // globals.curSlidePosition = (wtop - panelTop) / panelHeight;
                        // globals.$curSlide = $panel;
                        // globals.curSlideIndex = i;

                        is_current_panelizer = true
                        return i
                    }
                }

                is_current_panelizer = false

                return 0
            }

            var prev_data_bg

            function onSlideChange () {
                var data_bg = $current_panel.data('bg')
                if (prev_data_bg) {
                    $body.removeClass(prev_data_bg)
                }
                if (data_bg) {
                    var new_data_bg = 'data-bg-' + data_bg
                    $body.addClass(new_data_bg)
                    prev_data_bg = new_data_bg
                }
                // data-bg
                // setPanelHash();
                // set current menu item
                if (!prevent_menu_item_shift) {
                    $nav
                        .find('li')
                        .eq(current_panel_index)
                        .addClass('current')
                        .siblings('.current')
                        .removeClass('current')
                }
            }

            // function setPanelHash() {
            // 	window.location.hash = 'slide-' + parent_index + '-' + current_panel_index;
            // }

            // function initSlideHash() {
            // 	var hash = window.location.hash.substring(1);
            // 	if (hash) {

            // 		window.console.log(hash, 'hash');

            // 		preventUpdateScroll = true;
            // 		var slidenum = parseFloat( hash.replace('slide-'+parent_index+'-','') );
            // 		gotoSlide(slidenum);
            // 		return true;
            // 	}
            // 	return false;
            // }

            function decimalRound (per) {
                var dec_count = 3,
                    dec_pow = Math.pow(10, dec_count)
                return Math.round(per * dec_pow) / dec_pow
            }

            function gotoSlide (index) {
                var $panel = $panels.eq(index)

                if (!$panel.length) {
                    $panel = $panels.first()
                }

                prevent_menu_item_shift = true
                var offset = $panel.offset().top
                current_panel_index = index

                $page.animate(
                    { scrollTop: offset },
                    {
                        duration: 500,
                        complete: function () {
                            // prevent changing current menu item until animation is done
                            prevent_menu_item_shift = false
                            preventUpdateScroll = false

                            // make sure all states are updated after animation is complete
                            onSlideChange()
                            updateScrollPercentage()
                        }
                    }
                )
            }

            function nextSlide () {
                var new_index = current_panel_index + 1
                if (new_index < $panels.length) {
                    gotoSlide(new_index)
                }
            }

            function previousSlide () {
                var new_index = current_panel_index - 1
                if (new_index >= 0) {
                    gotoSlide(new_index)
                }
            }

            function updateLoadbar (dec) {
                //$progress_bar.css('height', Math.round(100 * dec) + '%' );
                //var per = (100 * dec) + '%';
                if ($progress_bar.length) {
                    $progress_bar.css({
                        webkitTransform: 'scaleY(' + dec + ')',
                        MozTransform: 'scaleY(' + dec + ')',
                        msTransform: 'scaleY(' + dec + ')',
                        OTransform: 'scaleY(' + dec + ')',
                        transform: 'scaleY(' + dec + ')'
                    })
                }
            }

            function updateScrollPercentage () {
                // var percentage_outer = decimalRound( $document.scrollTop() / ($document.height() - w_height) ); // full page scroll percentage
                var percentage = decimalRound(
                    ($document.scrollTop() - $el.offset().top) /
                    ($document.height() -
                        w_height -
                        ($document.height() - $el.height()))
                ) // panel scroll percentage

                settings.onProgress(percentage)
                updateLoadbar(percentage)
            }

            //var is_contained = false;

            var prev_state = ''

            function updateNavPosition () {
                var st = $document.scrollTop(),
                    // container_bottom = $el.offset().top + $el.height(),
                    // menu_bottom = st + w_height,
                    style = {},
                    new_state = ''

                // if contain top setting
                // if ( $el.offset().top > st && new_state !== 'top' ) {
                // new_state = 'top';
                // style = {
                // 	'position' : 'absolute',
                // 	'top' : '0',
                // 	'bottom': 'auto'
                // };
                // }

                if (
                    ($el.offset().top < st && new_state !== 'fixed') ||
                    prev_state === ''
                ) {
                    new_state = 'fixed'
                    style = {
                        position: 'fixed',
                        top: '0',
                        bottom: 'auto'
                    }
                }

                // if ( container_bottom - menu_bottom <= 0  && new_state !== 'bottom' ) {

                // 	new_state = 'bottom';
                // 	style = {
                // 		'position' : 'absolute',
                // 		'top' : 'auto',
                // 		'bottom': '0'
                // 	};

                // }

                var navclass = st < 100
                $nav.toggleClass('intro-state', navclass)

                if (prev_state !== new_state) {
                    if ($progress.length) {
                        $progress.css(style)
                    }
                    $nav.css(style)
                    prev_state = new_state
                }
            }

            function updateScrollPosition () {
                updateNavPosition()

                if (preventUpdateScroll) {
                    return
                }

                updateScrollPercentage()

                var panelIndex = getCurrentPanelIndex()

                if (current_panel_index !== panelIndex) {
                    //var dir = current_panel_index < panelIndex ? 'up' : 'down';
                    //window.console.log( 'panel shifted ' + dir );

                    settings.onPanelChange(panelIndex, current_panel_index)

                    current_panel_index = panelIndex

                    $current_panel = $panels.eq(current_panel_index)
                    $current_panel
                        .addClass('current')
                        .siblings('.current')
                        .removeClass('current')

                    onSlideChange()
                }
            }

            /*
                  Bind events
                  */
            $window
                .on('resize', window.nel.utils.debounce(setPanelSize, 100))
                .on('scroll', window.nel.utils.throttle(updateScrollPosition, 100))

            $document.on('keydown', function (event) {
                if (!is_current_panelizer) {
                    return
                }
                var prevent = false
                switch (event.which) {
                    // case 37: // left
                    // break;
                    // case 39: // right
                    // break;
                    case 38: // up
                        previousSlide()
                        prevent = true
                        break
                    case 40: // down
                        nextSlide()
                        prevent = true
                        break
                    default:
                        return
                }
                if (prevent) {
                    event.preventDefault()
                }
            })

            $nav.on('click', 'li', function (event) {
                event.preventDefault()
                var index = $(this).index()
                gotoSlide(index)
            })

            $panels.on('click', '[href="#next"]', function (event) {
                nextSlide()
                event.preventDefault()
            })

            // set panel sizes
            setPanelSize()

            /*
                  Fire in the hole!
                  • class is added so we can hide stuff until its initialized
                  */
            $el.addClass('plz-init')
        })
    }

    $('.panelizer').panelizer()
})(jQuery, document, window)
