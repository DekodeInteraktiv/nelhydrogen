<?php
// Trades
// http://ir.asp.manamind.com/products/html/trades.do?key=nel&lang=en
$trade_count = 10; // max number is 20
?>
<script type="text/html" id="<?php echo $feed['tmpl']; ?>">
    <h3><?php echo sprintf( __( 'Last %d trades', 'nel' ), $trade_count ); ?></h3>
    <table>
        <thead>
        <tr>
            <th><?php _e( 'Time', 'nel' ); ?></th>
            <th><?php _e( 'Price', 'nel' ); ?></th>
            <th><?php _e( 'Volume', 'nel' ); ?></th>
        </tr>
        </thead>
        <tbody>
        <%
        var trades = manamind[1].trades.trade;
        var count = Math.min(<?php echo $trade_count; ?>, trades.length);
        for (var i=0; i
        <count
                ; i++) {
                var trade=trades[i];
                %>
            <tr>
                <td data-filter="timestamp"><%=trade.time.text%></td>
                <td><%=trade.paid.text%></td>
                <td data-filter="round,separator"><%=trade.volume.text%></td>
				<?php /*
				<td><%=trade.buyer.text%></td>
				<td><%=trade.seller.text%></td>
				*/ ?>
            </tr>
            <%
            }
            %>
        </tbody>
    </table>
</script>