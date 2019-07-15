(function ($, document, window, undefined) {
    var product_ids = []

    $('.pw-ajax-popup-link').on('click', function (e) {
        e.preventDefault()
        $.magnificPopup.close()

        var $this = $(this)
        setTimeout(function () {
            $.magnificPopup.open({
                items: {
                    src: $this.attr('href')
                },
                type: 'ajax',
                ajax: {
                    settings: {
                        type: 'POST',
                        data: {
                            cookie: encodeURIComponent(document.cookie),
                            product_ids: product_ids
                        }
                    }
                }
            })
        }, 300)
    })

    $('[data-scope="ProductWizard"]').each(function () {
        var $this = $(this),
            $products = $this.find('.product-wizard__products'),
            $contact = $this.find('.product-wizard__contact'),
            $child_select = $this.find('.child-select-wrap')

        // Initial state
        $products.hide()
        $contact.hide()
        $child_select.hide()
        $this
            .find('.rec-prod')
            .addClass('hidden')
            .removeClass('visible')

        function unsetSelection () {
            $contact.hide()
            $products.hide()
            // $popup_button.data('form-extras', {
            //   product_ids: ''
            // });
        }

        // $.ajax({
        //   type: 'POST',
        //   url: window.data.ajax_url,
        //   data: {
        //     cookie: encodeURIComponent(document.cookie),
        //     action: 'save_cision_article',
        //     article: article
        //   },
        //   success: function(result) {
        //     if (result.success) {
        //       if (result.data.permalink) {
        //         window.location.href = result.data.permalink;
        //       }
        //     }
        //   }
        // });

        //
        $this.find('.main-select').on('change', function () {
            $child_select.show()

            $this.find('.child-select').val(
                $this
                    .find('.child-select')
                    .find('option')
                    .first()
                    .val()
            )

            $this
                .find('.rec-prod')
                .addClass('hidden')
                .removeClass('visible')
        })

        //
        $this.find('.child-select').on('change', function () {
            var val = $(this).val()
            $this
                .find('.rec-prod')
                .addClass('hidden')
                .removeClass('visible')
            product_ids = []

            if (val) {
                var $selected_products = $this.find('.rec-prod-' + val)

                $contact.show()
                $products.show()
                $selected_products.addClass('visible').removeClass('hidden')

                $selected_products
                    .find('.product-wizard__product')
                    .each(function (params) {
                        product_ids.push($(this).data('id'))
                    })

                // Add data to popup button
                // $popup_button.data('form-extras', {
                //   product_ids: $selected_products.data('products')
                // });
                // $('.contact-form').
            } else {
                unsetSelection()
            }
        })
    })
})(jQuery, document, window)
