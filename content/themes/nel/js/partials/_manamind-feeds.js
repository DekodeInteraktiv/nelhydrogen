(function ($, document, window, undefined) {
    // Object.defineProperty(String.prototype, "removeCDATA", {
    // 	value: function () {
    // 		"use strict";
    // 		return this.replace('<![CDATA[', '').replace(']]>', '');
    // 	}
    // });

    $.fn.manamindFeed = function () {
        return this.each(function () {
            var $container = $(this),
                template_id = $container.data('tmpl')

            /*
      
                  XML to JSON
      
                  */

            function xmlToJson (xml) {
                // Create the return object
                var obj = {}

                if (xml.nodeType === 1) {
                    // element
                    // do attributes
                    if (xml.attributes.length > 0) {
                        obj['@attributes'] = {}
                        for (var j = 0; j < xml.attributes.length; j++) {
                            var attribute = xml.attributes.item(j)
                            obj['@attributes'][attribute.nodeName] = attribute.nodeValue
                        }
                    }
                } else if (xml.nodeType === 3) {
                    // text
                    obj = xml.nodeValue
                } else if (xml.nodeType === 4) {
                    // CDATA
                    obj = xml.nodeValue
                }

                // do children
                if (xml.hasChildNodes()) {
                    for (var i = 0; i < xml.childNodes.length; i++) {
                        var item = xml.childNodes.item(i)
                        var nodeName = item.nodeName.replace('#', '')
                        if (typeof obj[nodeName] === 'undefined') {
                            obj[nodeName] = xmlToJson(item)
                        } else {
                            if (typeof obj[nodeName].push === 'undefined') {
                                var old = obj[nodeName]
                                obj[nodeName] = []
                                obj[nodeName].push(old)
                            }
                            obj[nodeName].push(xmlToJson(item))
                        }
                    }
                }
                return obj
            }

            /*
      
                  Formatting
      
                  */

            function ucfirst (str) {
                str += ''
                var f = str.charAt(0).toUpperCase()
                return f + str.substr(1)
            }

            function zeroPad (num) {
                return ('0' + num).slice(-2)
            }

            function zeroPadMonth (date) {
                return zeroPad(date.getMonth() + 1)
            }

            function dateFormatDay (date) {
                return (
                    zeroPad(date.getDate()) +
                    '.' +
                    zeroPadMonth(date) +
                    '.' +
                    date.getFullYear()
                )
            }

            function dateFormat (date) {
                return (
                    dateFormatDay(date) +
                    ' ' +
                    zeroPad(date.getHours()) +
                    ':' +
                    zeroPad(date.getMinutes())
                )
            }

            function parseDate (timestamp) {
                var date = new Date(parseFloat(timestamp))
                return dateFormat(date)
            }

            function parseDateUTC (timestamp) {
                var date = new Date(timestamp)
                return dateFormatDay(date)
            }

            function decimalRound (number, decimals) {
                var dec = decimals === undefined ? 2 : decimals,
                    increment = Math.pow(10, dec)
                return Math.round(parseFloat(number) * increment) / increment
            }

            function numberWithCommas (x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
            }

            function parseCEST (text) {
                var date = text.replace('CEST', '')
                return new Date(date)
            }

            function parseStrtotime (text) {
                var date = parseCEST(text)
                return dateFormatDay(date)
            }

            function removeTrailingZeros (text) {
                // remove trailing zeros
                text = text + ''
                text = text.replace(/(\.[0-9]*?)0+$/, '$1')
                text = text.replace(/\.$/, '')
                return text
            }

            // function getInfoTypeText(key) {
            //   var text = key;
            //   key = key.toLowerCase();
            //   if (key in information_types) {
            //     text = information_types[key].title;
            //   }
            //   return text;
            // }

            /*
      
                  Apply text filters
      
                  */

            function applyFilters (html) {
                var $html = $(html)
                $html.find('[data-filter]').each(function () {
                    var $this = $(this),
                        text = $this.text(),
                        filters = $this.data('filter').split(','),
                        num_class = ''

                    for (var i = 0; i < filters.length; i++) {
                        var filter = filters[i]

                        if (filter === 'round') {
                            text = decimalRound(text, 2)
                        }
                        if (filter === 'separator') {
                            text = numberWithCommas(text)
                            text = removeTrailingZeros(text)
                        }
                        if (filter === 'timestamp') {
                            text = parseDate(text)
                        }
                        if (filter === 'strtotime') {
                            text = parseStrtotime(text)
                        }
                        if (filter === 'percent') {
                            text = text + '%'
                        }
                        if (filter === 'cleantitle') {
                            text = ucfirst(text.replace(/nel asa: |nel - |NEL – /gi, ''))
                        }
                        if (filter === 'parseutc') {
                            text = parseDateUTC(text)
                        }
                        // if (filter === 'infotype') {
                        //   text = getInfoTypeText(text);
                        // }

                        // add number helper classes
                        if (!isNaN(text)) {
                            num_class = 'num'
                            text = removeTrailingZeros(text)

                            if (parseFloat(text) === 0) {
                                num_class += ' zero'
                            } else {
                                num_class += text > 0 ? ' pos' : ' neg'
                            }
                        }
                    }

                    $this.text(text).addClass(num_class)
                })

                return $html
            }

            /*
      
                  Callbacks
      
                  */

            function feedLoaded (data) {
                var json = xmlToJson(data),
                    $tmpl = $('#' + template_id)

                // multifeed support

                json_combo.combo.push(json)

                if (feed_load_count < feed_total - 1) {
                    feed_load_count++
                    loadFeed()
                    return
                }

                if (feed_total > 0) {
                    json = json_combo
                }

                //

                if ($tmpl.length) {
                    var html = window.tmpl(template_id, json),
                        $html = applyFilters(html)

                    $container.html($html).addClass('feed-loaded')

                    if ($tmpl.data('debug')) {
                        window.console.log(data, json)
                    }
                } else {
                    window.console.log('Template missing ' + template_id)
                    $container.html('').addClass('feed-error')
                }
            }

            function feedError (xhr, ajaxOptions, thrownError) {
                window.console.log(xhr, ajaxOptions, thrownError)
            }

            /*
      
                  Load feed
      
                  */

            function loadFeed () {
                var feed_load_url

                if (typeof feed_url !== 'string') {
                    feed_total = feed_url.length
                    feed_load_url = feed_url[feed_load_count]
                } else {
                    feed_load_url = feed_url
                }

                $.ajax({
                    type: 'GET',
                    url: feed_load_url,
                    dataType: 'xml',
                    error: feedError,
                    success: feedLoaded
                })
            }

            var feed_total = 0,
                feed_load_count = 0,
                json_combo = { combo: [] },
                feed_url = $container.data('feed')

            // if ( typeof feed_url !== 'string' ) {
            // 	feed_total = feed_url.length;
            // 	feed_load_url = feed_url[0];
            // }else{
            // 	feed_load_url = feed_url;

            // }

            loadFeed()
        })
    }

    $('.manamind-feed').manamindFeed()

    function loadXMLData (xmlURL, callback) {
        $.ajax({
            type: 'GET',
            url: xmlURL,
            dataType: 'xml',
            success: callback
        })
    }

    $('.markets-disclaimer').each(function () {
        var $this = $(this),
            xmlURL = $this.data('xml'),
            string = $this.data('string')
        loadXMLData(xmlURL, function (xml) {
            var $xml = $(xml),
                author = $xml.find('author').text(),
                delay = $xml.find('delay').text(),
                currency = $xml.find('currency').text()
            string = string
                .replace('%author%', author)
                .replace('%delay%', delay)
                .replace('%currency%', currency)
            $this.html(string)
        })
    })

    $.fn.manamindHTMLFeed = function () {
        return this.each(function () {
            var $this = $(this),
                feed_url = $this.data('url')

            function feedLoaded (data) {
                $this.html(data)
                window.console.log('feed', data)
            }

            function feedError (xhr, ajaxOptions, thrownError) {
                window.console.log(xhr, ajaxOptions, thrownError)
            }

            $.ajax({
                type: 'GET',
                url: feed_url,
                //dataType: "xml",
                error: feedError,
                success: feedLoaded
            })

            window.console.log('load', feed_url)
        })
    }

    $('.manamind-html-feed').manamindHTMLFeed()

    // 	var o = document.getElementById('iframe'); o.contentWindow.postMessage('Info', '*'); window.addEventListener('message', receiver, false); function receiver(e) {
    // document.getElementById('ir').height = e.data; }

    // var count = 0;

    function resizeManamindIframe () {
        $('.manamind-iframe-wrap').each(function () {
            var $this = $(this),
                $iframe = $this.find('iframe'),
                iframe = $iframe[0]

            iframe.contentWindow.postMessage('Info', '*')

            function receiver (event) {
                // if (count<10) {
                // 	window.console.log(this, event);
                // 	count++;
                // }
                $this.height(event.data + 10)
            }

            if (!$this.data('has-receiver')) {
                $this.data('has-receiver', true)
                window.addEventListener('message', receiver, false)

                $iframe.on('load', function () {
                    resizeManamindIframe()
                })
            }
        })
    }

    $(window).on('resize', window.nel.utils.throttle(resizeManamindIframe, 100))
    resizeManamindIframe()

    // $('.manamind-iframe').on('load', resizeManamindIframe);
})(jQuery, document, window)
