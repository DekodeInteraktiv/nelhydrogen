(function ($, document, window, undefined) {
    // Generate failed subscription string to keep values after post
    $('.cision-form').each(function () {
        var $form = $(this)

        var $error_url_input = $form.find('[name=redirectUrlSubscriptionFailed]'),
            error_url = $error_url_input.val()

        function generateCisionPostString () {
            var string = ''
            $form.find('.cision-autofill').each(function () {
                var $this = $(this)
                string +=
                    '&' + $this.attr('name') + '=' + encodeURIComponent($this.val())
            })
            $error_url_input.val(error_url + string)
        }

        $form.find('.cision-autofill').on('keyup', generateCisionPostString)
        generateCisionPostString()
    })

    var $form_scrollto = $('.cision-form-scrollto'),
        $document = $(document)

    if ($form_scrollto.length) {
        $document.scrollTop($form_scrollto.offset().top)
        $document.on('cision_feed_loaded', function () {
            $document.scrollTop($form_scrollto.offset().top)
        })
    }
})(jQuery, document, window)
