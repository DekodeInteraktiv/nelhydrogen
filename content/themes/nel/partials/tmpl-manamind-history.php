<?php
// History long
?>
<script type="text/html" id="<?php echo $feed['tmpl']; ?>">
    <h3><?php _e( 'Historical profit', 'nel' ); ?></h3>
    <%
    var pShort = combo[0].manamind[1].historicalProfitShort;
    var pLong = combo[1].manamind[1].historicalProfitLong;
    %>
    <table class="history-long-term">
        <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td><?php _e( 'High (this year)', 'nel' ); ?></td>
            <td data-filter="round"><%=pShort.yearHigh.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Low (this year)', 'nel' ); ?></td>
            <td data-filter="round"><%=pShort.yearLow.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Profit last week', 'nel' ); ?></td>
            <td data-filter="round,percent"><%=pShort.change7DaysPercent.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( 'Profit %d months', 'nel' ), 3 ); ?></td>
            <td data-filter="round,percent"><%=pShort.change3MonthsPercent.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( 'Profit %d months', 'nel' ), 6 ); ?></td>
            <td data-filter="round,percent"><%=pShort.change6MonthsPercent.text%></td>
        </tr>

        <tr>
            <td><?php _e( 'Profit 1 year', 'nel' ); ?></td>
            <td data-filter="round,percent"><%=pLong.change1YearPercent.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( 'Profit %d years', 'nel' ), 3 ); ?></td>
            <td data-filter="round,percent"><%=pLong.change3YearsPercent.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( 'Profit %d years', 'nel' ), 5 ); ?></td>
            <td data-filter="round,percent"><%=pLong.change5YearsPercent.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Profit this year', 'nel' ); ?></td>
            <td data-filter="round,percent"><%=pLong.changeYearPercent.text%></td>
        </tr>
        </tbody>
    </table>
</script>