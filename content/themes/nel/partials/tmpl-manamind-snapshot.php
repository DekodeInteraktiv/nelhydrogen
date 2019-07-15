<?php
// Snapshot
?>
<script type="text/html" id="<?php echo $feed['tmpl']; ?>">
    <%
    var data = manamind[1].snapshot;
    %>
    <table class="history-short-term">
        <thead>
        <tr>
            <th>Ticker</th>
            <th>Last</th>
            <th>Volume</th>
            <th>Change</th>
            <th>%</th>
            <th>Bid</th>
            <th>Ask</th>
            <th>High</th>
            <th>Low</th>
            <th>Turnover</th>
            <th>Time</th>
            <th>Close</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><%=data.ticker.text%></td>
            <td><%=data.last.text%></td>
            <td data-filter="round,separator"><%=data.volume.text%></td>
            <td data-filter="round"><%=data.change.text%></td>
            <td data-filter="round,percent"><%=data.changePercent.text%></td>
            <td><%=data.bid.text%></td>
            <td><%=data.ask.text%></td>
            <td><%=data.high.text%></td>
            <td><%=data.low.text%></td>
            <td data-filter="round,separator"><%=data.amount.text%></td>
            <td data-filter="timestamp"><%=data.time.text%></td>
            <td><%=data.close.text%></td>
        </tr>
        </tbody>
    </table>
</script>