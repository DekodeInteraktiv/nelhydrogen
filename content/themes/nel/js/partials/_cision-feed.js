(function ($, document, window, undefined) {
    Object.defineProperty(String.prototype, 'removeCDATA', {
        value: function () {
            'use strict'
            return this.replace('<![CDATA[', '').replace(']]>', '')
        }
    })

    function nMonth (date) {
        return ('0' + (date.getMonth() + 1)).slice(-2)
    }

    function nDay (date) {
        return ('0' + date.getDate()).slice(-2)
    }

    function nelGetEndDate () {
        var tomorrow = new Date().getTime() + 86400000, // 86400000 = 1 day in milliseconds
            date = new Date(tomorrow)
        return date.getFullYear() + '-' + nMonth(date) + '-' + nDay(date)
    }

    function nelParseDate (timestamp) {
        var date = new Date(timestamp)
        return nDay(date) + '.' + nMonth(date) + '.' + date.getFullYear()
    }

    // vars

    var feedIsLoading = false,
        $feedContainer = $('.cision-feed'),
        $loader = $('.tmpl-cision-feed-loader'),
        pageSize = 50,
        pageIndex = 1,
        startDate = '2001-01-01',
        endDate = nelGetEndDate(),
        initial_load = true

    // save article to search results
    function maybeSaveArticle ($release, titleClean, bodyClean, attachments) {
        var atts = {}

        $.each($release[0].attributes, function () {
            if (this.specified) {
                atts[this.name] = this.value
            }
        })

        // var attachments = getReleaseAttachments($release);

        var article = {
            attributes: atts,
            title: titleClean,
            body: bodyClean, //$release.children('Body').html().removeCDATA(),
            attachments: attachments
        }

        $.ajax({
            type: 'POST',
            url: window.data.ajax_url,
            data: {
                cookie: encodeURIComponent(document.cookie),
                action: 'save_cision_article',
                article: article
            },
            success: function (result) {
                if (result.success) {
                    if (result.data.permalink) {
                        window.location.href = result.data.permalink
                    }
                }
            }
        })
    }

    function getReleaseAttachments ($release) {
        var attachments = []

        $release
            .children('Files')
            .find('File')
            .each(function () {
                var $file = $(this),
                    createDate = $file.attr('CreateDateUTC'),
                    title = $file
                        .children('Title')
                        .html()
                        .removeCDATA(),
                    filename = $file
                        .children('FileName')
                        .html()
                        .removeCDATA(),
                    url = $file
                        .children('Url')
                        .html()
                        .removeCDATA()

                var att_obj = {
                    title: title,
                    filename: filename,
                    url: url,
                    createDate: createDate
                }

                attachments.push(att_obj)
            })

        return attachments
    }

    var information_types = window.data.cision_infotypes

    function ucfirst (str) {
        str += ''
        var f = str.charAt(0).toUpperCase()
        return f + str.substr(1)
    }

    function cleanTitle (title) {
        return ucfirst(title.replace(/nel asa: |nel - |NEL – /gi, ''))
    }

    // load
    function loadCisionFeed (feedUniqueIdentifier) {
        if (feedIsLoading) {
            return
        }

        $feedContainer.html($loader.html())
        feedIsLoading = true

        $.ajax({
            type: 'GET',
            url:
                '//publish.ne.cision.com/Release/ListReleasesSortedByPublishDate/?feedUniqueIdentifier=' +
                feedUniqueIdentifier +
                '&pageSize=' +
                pageSize +
                '&pageIndex=' +
                pageIndex +
                '&startDate=' +
                startDate +
                '&endDate=' +
                endDate,
            dataType: 'xml',
            error: function (xhr, ajaxOptions, thrownError) {
                feedIsLoading = false
                $feedContainer.html('<li>' + thrownError + '</li>')
            },
            success: function (data) {
                feedIsLoading = false

                var $xml = $(data),
                    build = '',
                    info_type_check = []

                // info_type_filter_build += '<div><input id="" type="checkbox" value=""><label for="cit-all">All</label></div>';

                // build the list
                $xml.find('Release').each(function () {
                    var $this = $(this),
                        information_type = $this.attr('InformationType').toLowerCase(),
                        title = $this.children('Title').text(),
                        publish_date = nelParseDate($this.attr('PublishDateUtc')),
                        attachments = getReleaseAttachments($this),
                        information_type_text = ''

                    if (information_type in information_types) {
                        information_type_text = information_types[information_type].title
                        if (info_type_check.indexOf(information_type) === -1) {
                            info_type_check.push(information_type)
                        }
                    }

                    build += window.tmpl('tmpl_cision_item', {
                        date: publish_date,
                        title: cleanTitle(title),
                        information_type: information_type,
                        information_type_text: information_type_text,
                        attachments: attachments,
                        url: $this.attr('DetailUrl')
                    })
                })

                // build filter nav
                // var info_type_filter_build = '<div class="cision-info-type-filter">';
                // for (var key in information_types) {
                //   if (info_type_check.indexOf(key) !== -1) {
                //     var i_type = information_types[key];
                //     info_type_filter_build +=
                //       '<div class="filter"><input id="cit-' +
                //       key +
                //       '" type="checkbox" value="' +
                //       key +
                //       '"/><label for="cit-' +
                //       key +
                //       '">' +
                //       i_type.menu_title +
                //       '</label></div>';
                //   }
                // }
                // info_type_filter_build += '</div>';

                $feedContainer.html(build)

                //

                if (initial_load) {
                    //

                    // var $feed_items = $('.feed-item'),
                    //   $info_type_filter = $(info_type_filter_build).appendTo(
                    //     '.cision-feed-tools'
                    //   ),
                    //   $checkboxes = $info_type_filter.find('[type=checkbox]');

                    // $checkboxes.on('change', function() {
                    //   var filters = [],
                    //     filter,
                    //     $filtered_feed_items;

                    //   $checkboxes.each(function() {
                    //     var $this = $(this);
                    //     if ($this.is(':checked')) {
                    //       var val = $(this).val();
                    //       if (val) {
                    //         filters.push('.info-type-' + val);
                    //       }
                    //     }
                    //   });

                    //   filter = filters.join(',');

                    //   if (filter !== '') {
                    //     $filtered_feed_items = $feed_items.filter(filter);
                    //   } else {
                    //     $filtered_feed_items = $feed_items;
                    //   }

                    //   $feedContainer.html($filtered_feed_items);
                    // });

                    //

                    $(document).trigger('cision_feed_loaded')
                    initial_load = false
                }
            }
        })
    }

    if ($feedContainer.length) {
        $('.cision-feed-select').on('change', function () {
            var feedId = $(this).val()
            loadCisionFeed(feedId)
        })

        var initId = $('.cision-feed-select').val()
        if (initId) {
            loadCisionFeed(initId)
        }
    }

    $('.js-cision-feed,.tmpl-cision-minifeed').on(
        'click',
        '.detail-link',
        function (event) {
            var url = $(this).attr('href')

            $.ajax({
                type: 'GET',
                dataType: 'xml',
                url: url,
                success: function (result) {
                    var $xml = $(result),
                        bodyText = $xml.find('HtmlBody').html(),
                        $release = $xml.find('Release'),
                        publish_date = nelParseDate($release.attr('PublishDateUtc')),
                        attachments = getReleaseAttachments($release)

                    // clean text before output
                    bodyText = bodyText.removeCDATA()
                    var bodyClean = $('<div>' + bodyText + '</div>') // wrap in div to force select full body content and not individual elements
                    bodyClean.find('[style]').removeAttr('style')
                    bodyClean = bodyClean.html()
                    bodyClean = bodyClean.replace(/<\/?span[^>]*>/g, '') // remove the insane use of <span>

                    var titleClean = cleanTitle(
                        $xml
                            .find('Title')
                            .html()
                            .removeCDATA()
                    )

                    maybeSaveArticle($release, titleClean, bodyClean, attachments)
                },
                error: function () {
                    // go to url -> url = xml
                }
            })

            event.preventDefault()
        }
    )
})(jQuery, document, window)
