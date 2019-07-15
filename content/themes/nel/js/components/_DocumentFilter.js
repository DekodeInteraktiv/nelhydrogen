(function ($) {
    $('[data-scope="DocumentFilter"]').each(function () {
        var $el = $(this),
            $itemList = $($el.data('filter-list')),
            $allItems = $itemList.find('[data-filter]'),
            $filters = $el.find('[data-filter]')

        $filters.on('click', function (event) {
            var $this = $(this),
                filter = $this.data('filter')

            if ($this.data('title-change')) {
                $($this.data('title-change')).text($this.text())
            }

            $filters
                .not(this)
                .closest('li')
                .removeClass('button-nav__item--current')
            $(this)
                .closest('li')
                .addClass('button-nav__item--current')

            if (filter) {
                $allItems.hide()
                $allItems
                    .filter('[data-filter="' + filter + '"],[data-filter="*"]')
                    .show()
            } else {
                $allItems.show()
            }

            event.preventDefault()
        })
    })
})(jQuery)
