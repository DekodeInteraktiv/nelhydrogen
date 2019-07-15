<?php
// Snapshot
?>
<script type="text/html" id="<?php echo $feed['tmpl']; ?>">
    <h3><?php _e( 'Share performance', 'nel' ); ?></h3>
    <%
    var data = manamind[1].sharePerformance;
    %>
    <table>
        <thead>
        <tr>
            <th><?php _e( 'Period', 'nel' ); ?></th>
            <th>+/-%</th>
            <th><?php _e( 'Close', 'nel' ); ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>7 days</td>
            <td data-filter="round,percent"><%=data.change7DaysPercent.text%></td>
            <td data-filter="round"><%=data.close7Days.text%></td>
        </tr>
        <tr>
            <td><?php _e( '1 month', 'nel' ); ?></td>
            <td data-filter="round,percent"><%=data.change1MonthPercent.text%></td>
            <td data-filter="round"><%=data.close1Month.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( '%d months', 'nel' ), 3 ); ?></td>
            <td data-filter="round,percent"><%=data.change3MonthsPercent.text%></td>
            <td data-filter="round"><%=data.close3Months.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( '%d months', 'nel' ), 6 ); ?></td>
            <td data-filter="round,percent"><%=data.change6MonthsPercent.text%></td>
            <td data-filter="round"><%=data.close6Months.text%></td>
        </tr>
        <tr>
            <td><?php _e( '1 year', 'nel' ); ?></td>
            <td data-filter="round,percent"><%=data.change1YearPercent.text%></td>
            <td data-filter="round"><%=data.close1Year.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( '%d years', 'nel' ), 3 ); ?></td>
            <td data-filter="round,percent"><%=data.change3YearsPercent.text%></td>
            <td data-filter="round"><%=data.close3Years.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( '%d years', 'nel' ), 5 ); ?></td>
            <td data-filter="round,percent"><%=data.change5YearsPercent.text%></td>
            <td data-filter="round"><%=data.close5Years.text%></td>
        </tr>
        </tbody>
    </table>
</script>