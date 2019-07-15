/*jshint unused:false */
/*global ScrollMagic, TweenMax, TimelineMax  */

(function ($) {
    var hydrogen = {
        // http://greensock.com/svg-tips
        // http://greensock.com/ease-visualizer
        // http://scrollmagic.io/docs/

        init: function (co2data) {
            // setup plugin names

            var instance = this,
                controller = new ScrollMagic.Controller({
                    globalSceneOptions: {},
                    loglevel: 2
                })

            /*
              Init galaxy
              */

            var $galaxy = $('.galaxy-scrollmagic').galaxy({
                speed: 5,
                color: 0xaf00ff
            })

            var scrollProgress = 1,
                particleSpeedMax = 100,
                currentYear = 2016,
                co2currentYear = 410,
                co2initYear = 260,
                initYear = 1600,
                futureYear = 2200,
                currentSlide

            $('.next-sm-slide').on('click', function (event) {
                var nextslide = currentSlide + 1
                var newScrollPos = $('.trigger-top-' + nextslide).offset().top + 10
                $('html,body').animate({ scrollTop: newScrollPos }, { duration: 1000 })
                event.preventDefault()
            })

            /*
              SET UP SUBTITLES
              */

            $('.sm-panel').each(function (i) {
                var panel_class = '.text-panel-' + i,
                    $panel = $(panel_class)

                new ScrollMagic.Scene({
                    triggerElement: '.trigger-top-' + i,
                    duration: function () {
                        if (i === 3) {
                            return $('.trigger-top-' + i).height() / 2
                        } else {
                            return $('.trigger-top-' + i).height()
                        }
                    }
                })
                    .on('enter', function () {
                        currentSlide = i
                        $panel.removeClass('before after').addClass('during')
                    })
                    .on('leave', function (event) {
                        if (event.state === 'BEFORE') {
                            $panel.addClass('before')
                        } else if (event.state === 'AFTER') {
                            $panel.addClass('after')
                        }
                    })
                    //.addIndicators()
                    .addTo(controller)
            })

            /*
              SHOW SUN
              */

            var sunTweenShow = TweenMax.fromTo(
                '.sun',
                1,
                { scale: 0 },
                { scale: 1, ease: window.Circ.easeInOut }
            )

            new ScrollMagic.Scene({
                triggerElement: '.scene-fuel',
                duration: 300,
                offset: -200
            })
                .setTween(sunTweenShow)
                //.addIndicators({name: "sun"})
                .addTo(controller)

            // sun label

            new ScrollMagic.Scene({
                triggerElement: '.scene-fuel',
                offset: 100,
                duration: function () {
                    return $('.scene-fuel').height() / 2
                }
            })
                .on('enter', function () {
                    $('.sun-label').addClass('visible')
                })
                .on('leave', function () {
                    $('.sun-label').removeClass('visible')
                })
                // .setTween(sunLabelTween)
                //.addIndicators({name: "sun label"})
                .addTo(controller)

            /*
              SHOW EARTH
              */

            var earthTween = TweenMax.fromTo(
                '.earth',
                1,
                { scale: 0, top: 100, left: -150 },
                { scale: 1, top: 0, left: 0, ease: window.Circ.easeInOut }
            )

            new ScrollMagic.Scene({
                triggerElement: '.scene-fuel',
                offset: 100,
                duration: function () {
                    return $('.scene-fuel').height() + 150
                }
            })
                .setTween(earthTween)
                //.addIndicators({name: "earth"})
                .addTo(controller)

            /*
              HIDE SUN
              */

            var sunTweenHide = TweenMax.to('.sun', 1, {
                scale: 0,
                ease: window.Circ.easeInOut
            })

            new ScrollMagic.Scene({
                triggerElement: '.scene-fuel',
                offset: 200,
                duration: function () {
                    return $('.scene-fuel').height() + 150
                }
            })
                .setTween(sunTweenHide)
                //.addIndicators({name: "sun hide"})
                .addTo(controller)

            /*
              EARTH MOVE LEFT
              */

            var earthFilterShow = TweenMax.fromTo(
                '.earth .filter',
                1,
                { opacity: 0 },
                { opacity: 1 }
                ),
                $yearCounter = $('.earth .counter-year'),
                $co2Counter = $('.earth .counter-co2')

            new ScrollMagic.Scene({
                triggerElement: '.scene-pollution',
                duration: function () {
                    return $('.scene-pollution').height()
                }
            })
                .setTween(earthFilterShow)
                .on('enter', function () {
                    $yearCounter.addClass('visible')
                    $co2Counter.addClass('visible')
                })
                .on('leave', function () {
                    $yearCounter.removeClass('visible')
                    $co2Counter.removeClass('visible')
                })
                .on('progress', function (event) {
                    var currentStepNumber =
                        Math.floor(event.progress * (co2data.length - 1 - initYear)) +
                        initYear
                    var currentStep = co2data[currentStepNumber]
                    var year = currentStep.year
                    var co2 = Math.round(currentStep.data_mean_global * 100) / 100
                    $yearCounter.text('Year ' + year)
                    $co2Counter.find('.count').text(co2)
                })
                //.addIndicators({name: "earth filter"})
                .addTo(controller)

            /*
              EARTH SHOW RENEWABLE
              */

            // inital state
            TweenMax.set('.earth .renewable, .earth .fossil', { opacity: 0 })

            var tl = new TimelineMax()
                .to('.earth .renewable', 1, {
                    opacity: 1
                })
                .to(
                    '.earth .renewable',
                    1,
                    {
                        opacity: 0
                    },
                    '+=1'
                )
                .to('.earth .fossil', 1, {
                    opacity: 1
                })
                .to(
                    '.earth .fossil',
                    1,
                    {
                        opacity: 0
                    },
                    '+=2'
                )

            new ScrollMagic.Scene({
                triggerElement: '.trigger-top-3',
                duration: function () {
                    return $('.trigger-top-3').height()
                }
            })
                .setTween(tl)
                //.addIndicators({name: "fossil"})
                .addTo(controller)

            /*
              HIDE EARTH
              */

            new ScrollMagic.Scene({
                triggerElement: '.scene-challenge',
                offset: -350,
                duration: function () {
                    return $('.scene-challenge').height() / 2
                }
            })
                .setTween('.earth, .earth-renewable', {
                    top: 200,
                    ease: window.Circ.easeIn
                })
                //.addIndicators({name: "hide earth"})
                .addTo(controller)

            new ScrollMagic.Scene({
                triggerElement: '.scene-challenge',
                offset: 200
            })
                .on('enter', function () {
                    TweenMax.set('.earth', { scale: 0, opacity: 0 })
                    //TweenMax.set('.earth .filter', {opacity:0});
                })
                .on('leave', function (event) {
                    if (event.state === 'BEFORE') {
                        TweenMax.set('.earth', { scale: 1, opacity: 1 })
                    }
                })
                //.addIndicators({name: "hide earth"})
                .addTo(controller)

            /*
              SHOW ENERGY DENSITY
              */

            TweenMax.set('.energy-density', { opacity: 0 })

            var edTween = new TimelineMax()
                .to('.energy-density', 1, { opacity: 1 })
                .to('.energy-density', 1, { opacity: 0 }, '+=5')

            new ScrollMagic.Scene({
                triggerElement: '.trigger-top-5',
                duration: function () {
                    return $('.trigger-top-5').height()
                }
            })
                .setTween(edTween)
                //.addIndicators()
                .addTo(controller)

            /*
              SHOW WATER CYCLE
              */

            TweenMax.set('.water-cycle', { opacity: 0 })

            new ScrollMagic.Scene({
                triggerElement: '.trigger-top-6',
                duration: 100
            })
                .setTween('.water-cycle', {
                    opacity: 1
                })
                //.addIndicators()
                .addTo(controller)

            // HIDE WATER CYCLE
            new ScrollMagic.Scene({
                triggerElement: '.scene-future',
                offset: -100,
                duration: 200
            })
                .setTween('.water-cycle img', {
                    scale: 0.75
                })
                .on('enter', function () {
                    $('.water-cycle').show()
                })
                .on('leave', function (event) {
                    if (event.state === 'AFTER') {
                        $('.water-cycle').hide()
                    }
                })
                //.addIndicators()
                .addTo(controller)

            /*
              SHOW EARTH
              */

            var showEarthTween = TweenMax.fromTo(
                '.earth',
                1,
                { top: 0, scale: 0, opacity: 1 },
                { scale: 1, opacity: 1, top: 0 }
            )

            new ScrollMagic.Scene({
                triggerElement: '.scene-future',
                offset: -100,
                duration: 200
            })
                .setTween(showEarthTween)
                //.addIndicators({name: "show earth"})
                .addTo(controller)

            // set counters

            new ScrollMagic.Scene({
                triggerElement: '.scene-future',
                offset: 300,
                duration: function () {
                    return $('.scene-future').height() - 200
                }
            })
                .setTween('.earth .filter', {
                    opacity: 0
                })
                .on('enter', function () {
                    $yearCounter.addClass('visible')
                    $co2Counter.addClass('visible')
                })
                .on('leave', function (event) {
                    // if (event.state==='BEFORE') {
                    $yearCounter.removeClass('visible')
                    $co2Counter.removeClass('visible')
                    // }
                })
                .on('progress', function (event) {
                    var year = instance.progressHelper(
                        currentYear,
                        futureYear,
                        event.progress
                        ),
                        co2 = instance.progressHelper(
                            co2currentYear,
                            co2initYear,
                            event.progress
                        )
                    $yearCounter.text(year)
                    $co2Counter.find('.count').text(co2)

                    scrollProgress = event.progress * particleSpeedMax
                    if (scrollProgress <= 3) {
                        scrollProgress = 3
                    }
                    $galaxy.trigger('setSpeed', scrollProgress)
                })
                //.addIndicators({name: "show counters"})
                .addTo(controller)

            /*
              EARTH OUTRO
              */

            new ScrollMagic.Scene({
                triggerElement: '.scene-outro',
                offset: 300,
                duration: function () {
                    return $('.scene-outro').height() / 2 - 300
                }
            })
                .setTween('.earth', {
                    scale: 0,
                    ease: window.Circ.easeOut,
                    top: 0
                })
                .on('progress', function (event) {
                    scrollProgress = (1 - event.progress) * particleSpeedMax
                    if (scrollProgress <= 3) {
                        scrollProgress = 3
                    }
                    $galaxy.trigger('setSpeed', scrollProgress)
                })
                //.addIndicators({name: "earth outro"})
                .addTo(controller)

            /*
              Everything is set up
              Remove loading class
              */

            $('#scrollmagic').removeClass('loading')
        },

        elementHeight: function (selector, multiplier, offset) {
            var calculated_height = 0
            if (offset === undefined) {
                offset = 0
            }
            if (multiplier === undefined) {
                multiplier = 1
            }
            var $elem = $(selector)
            if ($elem.length > 1) {
                $elem.each(function () {
                    calculated_height += $(this).outerHeight()
                })
            } else {
                calculated_height = $elem.outerHeight()
            }
            return calculated_height * multiplier + offset
        },

        winHeight: function (multiplier, offset) {
            if (offset === undefined) {
                offset = 0
            }
            if (multiplier === undefined) {
                multiplier = 1
            }
            return $(window).height() * multiplier + offset
        },

        progressHelper: function (min, max, per) {
            return min + Math.ceil(per * (max - min))
        }
    }

    if ($('#scrollmagic').length) {
        $('#scrollmagic').addClass('loading')

        $.ajax({
            url: window.data.scripts.scrollmagic,
            dataType: 'script',
            cache: true
        })
            .done(function () {
                $.ajax({
                    url: window.data.scripts.co2data,
                    success: function (response) {
                        hydrogen.init(response)
                    },
                    error: function (error) {
                        hydrogen.init(false)
                    }
                })
            })
            .fail(function (data, status, jqxhr) {
                $('#scrollmagic').removeClass('loading')
                window.console.log(data, status, jqxhr)
            })
    }
})(jQuery)
