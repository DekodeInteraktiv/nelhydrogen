(function ($, document, window, undefined) {
    /*
    Helper functions
    */

    function nelGetEndDate () {
        var tomorrow = new Date().getTime() + 86400000, // 86400000 = 1 day in milliseconds
            date = new Date(tomorrow)
        return date.getFullYear() + '-' + nMonth(date) + '-' + nDay(date)
    }

    function nMonth (date) {
        return ('0' + (date.getMonth() + 1)).slice(-2)
    }

    function nDay (date) {
        return ('0' + date.getDate()).slice(-2)
    }

    // function nelParseDate(timestamp) {
    //   var date = new Date(timestamp);
    //   return nDay(date) + '.' + nMonth(date) + '.' + date.getFullYear();
    // }

    // function ucfirst(str) {
    //   str += '';
    //   var f = str.charAt(0).toUpperCase();
    //   return f + str.substr(1);
    // }

    // function cleanTitle(title) {
    //   return ucfirst(title.replace(/nel asa: |nel - |NEL – /gi, ''));
    // }

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

    var feedUniqueIdentifier = '9b3a2801de',
        // feedIsLoading = false,
        pageSize = 50,
        pageIndex = 1,
        startDate = '2001-01-01',
        endDate = nelGetEndDate()
    // information_types = window.data.cision_infotypes;

    // save article to search results
    function maybeSaveArticle ($release, titleClean, bodyClean, attachments) {
        var atts = {}

        $.each($release[0].attributes, function () {
            if (this.specified) {
                atts[this.name] = this.value
            }
        })

        var article = {
            attributes: atts,
            title: titleClean,
            body: bodyClean,
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
                // console.log('article saved', result);
            }
        })
    }

    function getFullCisionArticle (url) {
        $.ajax({
            type: 'GET',
            dataType: 'xml',
            url: url,
            success: function (result) {
                var $xml = $(result),
                    bodyText = $xml.find('HtmlBody').html(),
                    $release = $xml.find('Release'),
                    attachments = getReleaseAttachments($release)

                // clean text before output
                bodyText = bodyText.removeCDATA()
                var bodyClean = $('<div>' + bodyText + '</div>') // wrap in div to force select full body content and not individual elements
                bodyClean.find('[style]').removeAttr('style')
                bodyClean = bodyClean.html()
                bodyClean = bodyClean.replace(/<\/?span[^>]*>/g, '') // remove the insane use of <span>

                var titleClean = $xml
                    .find('Title')
                    .html()
                    .removeCDATA()

                maybeSaveArticle($release, titleClean, bodyClean, attachments)
            }
        })
    }

    function loadCisionFeed () {
        var excludeIds = $('#js-cision-scraper').data('exclude'),
            excludeIdsArray = excludeIds.split(',')

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
                // console.log(thrownError);
            },
            success: function (data) {
                var $xml = $(data)
                // Build the list
                $xml.find('Release').each(function () {
                    var $this = $(this),
                        releaseId = $this.attr('Id')
                    if (excludeIdsArray.indexOf(releaseId) === -1) {
                        getFullCisionArticle($this.attr('DetailUrl'))
                    }
                })
            }
        })
    }

    if ($('#js-cision-scraper').length) {
        loadCisionFeed()
    }
})(jQuery, document, window)
