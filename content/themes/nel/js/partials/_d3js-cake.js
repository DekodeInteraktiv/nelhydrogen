(function ($, document, window, undefined) {
    var d3, arc

    function arcTween (element, outerRadius, delay) {
        element
            .transition()
            .duration(150)
            .delay(delay)
            .attrTween('d', function (d) {
                var i = d3.interpolate(d.outerRadius, outerRadius)
                return function (t) {
                    d.outerRadius = i(t)
                    return arc(d)
                }
            })
    }

    function setCenterText (d3arc) {
        var data = d3arc.data()[0].data,
            html =
                '<span class="percent">' +
                data.percent +
                '%</span><br>' +
                data.name +
                '<br>' +
                data.shares
        $('.center-text').html(html)
    }

    function unsetCenterText () {
        $('.center-text').html('')
    }

    function decimalRound (number, decimals) {
        var dec = decimals === undefined ? 2 : decimals,
            increment = Math.pow(10, dec)
        return Math.round(number * increment) / increment
    }

    function getUpdatedDate (time) {
        var timestamp = time.substring(0, 10),
            date = new Date(timestamp * 1000)
        return (
            ('0' + date.getDate()).slice(-2) +
            '.' +
            ('0' + (date.getMonth() + 1)).slice(-2) +
            '.' +
            date.getFullYear()
        )
    }

    function updateShareholderData (data, updated) {
        if (updated !== undefined) {
            var datestring = $piechart.data('strings').updated
            $('.shareholders-updated').text(datestring.replace('%s', updated))
        }

        var width = 600,
            height = 600,
            radius = Math.min(width, height) / 2,
            innerRadius = radius - 80,
            outerRadius = radius - 20

        var color = d3.scale
            .linear()
            .domain([1, 20])
            .interpolate(d3.interpolateHcl)
            .range([d3.rgb('#be00ff'), d3.rgb('#521970')])

        var pie = d3.layout
            .pie()
            .value(function (d) {
                return d.percent
            })
            .sort(null)

        //var cornerRadius = 3;

        arc = d3.svg
            .arc()
            .padRadius(outerRadius)
            //.cornerRadius(cornerRadius)
            // .outerRadius(radius - 20)
            .innerRadius(innerRadius)

        var svg = d3
            .select('.pie-chart')
            .append('svg')
            .attr('width', '100%')
            .attr('height', '100%')
            .attr('viewBox', '0 0 ' + width + ' ' + height + '')
            .append('g')
            .attr('transform', 'translate(' + width / 2 + ',' + height / 2 + ')')

        var $shareholderList = $('.shareholder-table')
            .find('tbody')
            .empty()

        svg
            .datum(data)
            .selectAll('path')
            .data(pie)
            .enter()
            .append('path')
            .attr('id', function (d, i) {
                var id = 'arc-' + (i + 1)

                // add item to list
                var listItem = '<tr data-id="' + id + '">'
                listItem += '<td>' + d.data.shares + '</td>'
                listItem += '<td>' + d.data.percent + '</td>'
                listItem += '<td>' + d.data.name + '</td>'
                listItem += '</tr>'
                $shareholderList.append(listItem)

                return id
            })
            .each(function (d) {
                // d3.select(this).classed('arc-'+i);
                // window.console.log( d3.select(this) );
                d.outerRadius = outerRadius - 20
            }) //
            .attr('fill', function (d, i, undefined) {
                //var col = Math.random() * 20;
                return color(i)
            })
            .attr('d', arc)
            .on('mouseover', function () {
                var that = d3.select(this),
                    id = that.attr('id')

                $('.shareholder-table')
                    .find('[data-id="' + id + '"]')
                    .addClass('hovering')
                setCenterText(that)

                arcTween(that, outerRadius, 0)
            })
            .on('mouseout', function () {
                var that = d3.select(this),
                    id = that.attr('id')

                $('.shareholder-table')
                    .find('[data-id="' + id + '"]')
                    .removeClass('hovering')
                unsetCenterText()

                arcTween(that, outerRadius - 20, 150)
            })

        $('.shareholder-table tbody')
            .on('mouseenter', 'tr', function () {
                var id = $(this).data('id'),
                    d3arc = d3.select('#' + id)
                setCenterText(d3arc)
                arcTween(d3.select('#' + id), outerRadius, 0)
            })
            .on('mouseleave', 'tr', function () {
                var id = $(this).data('id'),
                    d3arc = d3.select('#' + id)
                unsetCenterText()
                arcTween(d3arc, outerRadius - 20, 150)
            })

        $(window).trigger('resize')
    }

    function loadXMLData (xmlURL, callback) {
        $.ajax({
            type: 'GET',
            url: xmlURL,
            dataType: 'xml',
            success: callback
        })
    }

    function shareholdersLoaded (xml) {
        var $xml = $(xml),
            $shareholders = $xml.find('position')

        if ($shareholders.length) {
            var updated = getUpdatedDate($xml.find('updated').text()),
                collector = []

            $shareholders.each(function () {
                var $this = $(this)
                var shareholder = {
                    shares: $this.find('shares').text(),
                    percent: decimalRound($this.find('percentage').text(), 2),
                    name: $this.find('investor').text()
                }

                collector.push(shareholder)
            })

            updateShareholderData(collector, updated)
        }
    }

    function piechartfit () {
        var $parent = $piechart.parent(),
            p_width = $parent.width()
        $piechart.width(p_width).height(p_width)
    }

    function init_piechart_failed (data, status, jqxhr) {
        window.console.log('failed loading threejs', data, status, jqxhr)
    }

    function loadDisclaimer () {
        $('.shareholders-disclaimer').each(function () {
            var $this = $(this),
                xmlURL = $this.data('xml')
            loadXMLData(xmlURL, function (xml) {
                var $xml = $(xml)
                $this.html($xml.find('author').text())
            })
        })
    }

    function init_piechart () {
        d3 = window.d3
        var xmlURL = $piechart.data('xml')
        loadXMLData(xmlURL, shareholdersLoaded)
        $(window).on('resize', window.nel.utils.throttle(piechartfit, 100))
        piechartfit()
        loadDisclaimer()
    }

    var $piechart = $('.pie-chart')
    if ($piechart.length) {
        /*
            LOAD d3.js
            */
        $.ajax({
            url: window.data.scripts.d3,
            dataType: 'script',
            cache: true
        })
            .done(init_piechart)
            .fail(init_piechart_failed)
    }
})(jQuery, document, window)
