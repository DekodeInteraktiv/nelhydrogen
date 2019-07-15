(function ($, document, window, undefined) {

    var acf = window.acf

    if (acf) {

        // https://www.advancedcustomfields.com/resources/adding-custom-javascript-fields/

        acf.add_action('show_field', function ($field, context, undefined) {

            // window.console.log(context, $field);

        })

    }

})(jQuery, document, window)