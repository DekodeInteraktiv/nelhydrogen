<?php
// History short
?>
<script type="text/html" id="<?php echo $feed['tmpl']; ?>">
    <h3><?php _e( 'Historical profit', 'nel' ); ?></h3>
    <%
    var data = manamind[1].historicalProfitShort;
    %>
    <table class="history-short-term">
        <tr>
            <td><?php _e( 'High (this year)', 'nel' ); ?></td>
            <td data-filter="round"><%=data.yearHigh.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Low (this year)', 'nel' ); ?></td>
            <td data-filter="round"><%=data.yearLow.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Profit last week', 'nel' ); ?></td>
            <td data-filter="round,percent"><%=data.change7DaysPercent.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( 'Profit %d months', 'nel' ), 3 ); ?></td>
            <td data-filter="round,percent"><%=data.change3MonthsPercent.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( 'Profit %d months', 'nel' ), 6 ); ?></td>
            <td data-filter="round,percent"><%=data.change6MonthsPercent.text%></td>
        </tr>
    </table>
</script>