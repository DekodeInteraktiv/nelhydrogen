<?php
// Benchmarks
?>
<script type="text/html" id="<?php echo $feed['tmpl']; ?>">
    <h3><?php _e( 'Benchmarks', 'nel' ); ?></h3>
    <%
    var data = manamind[1].peerGroupBenchmark.company;
    %>
    <table class="history-short-term">
        <thead>
        <tr>
            <th><?php _e( 'Close', 'nel' ); ?></th>
            <th><?php _e( 'Currency', 'nel' ); ?></th>
            <th><?php _e( 'week', 'nel' ); ?></th>
            <th><?php _e( 'month', 'nel' ); ?></th>
            <th><?php _e( '3 months', 'nel' ); ?></th>
            <th><?php _e( '6 months', 'nel' ); ?></th>
            <th><?php _e( '1 year', 'nel' ); ?></th>
            <th><?php _e( '2 years', 'nel' ); ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><%=data.last.text%></td>
            <td><%=data.currency.text%></td>
            <td data-filter="round,percent"><%=data.CHANGE_WEEK_PCT.text%></td>
            <td data-filter="round,percent"><%=data.CHANGE_MONTH_PCT.text%></td>
            <td data-filter="round,percent"><%=data.CHANGE_3MONTHS_PCT.text%></td>
            <td data-filter="round,percent"><%=data.CHANGE_6MONTHS_PCT.text%></td>
            <td data-filter="round,percent"><%=data.CHANGE_1YEAR_PCT.text%></td>
            <td data-filter="round,percent"><%=data.CHANGE_2YEARS_PCT.text%></td>
        </tr>
        </tbody>
    </table>
</script>