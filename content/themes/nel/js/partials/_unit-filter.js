// @codekit-prepend quiet "../node_modules/nouislider/distribute/nouislider.min.js";

(function ($, document, window, undefined) {
    $('input[name="unit"]').on('click', function () {
        console.log($('input[name="unit"]:checked').val())
    })

    var noUiSlider = window.noUiSlider

    $('.range-slider').each(function () {
        // slider.noUiSlider.updateOptions(
        //   newOptions,
        //   true
        // );

        noUiSlider.create($(this)[0], {
            start: [20, 80],
            connect: true,
            range: {
                min: 0,
                max: 1000
            },
            pips: {
                mode: 'steps',
                stepped: true,
                density: 4
            },
            tooltips: true,
            step: 50
        })
    })
})(jQuery, document, window)
