<?php
// History long
?>
<script type="text/html" id="<?php echo $feed['tmpl']; ?>">
    <%
    var data = manamind[1].historicalProfitLong;
    %>
    <table class="history-long-term">
        <tr>
            <td><?php _e( 'Profit 1 year', 'nel' ); ?></td>
            <td data-filter="round,percent"><%=data.change1YearPercent.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( 'Profit %d years', 'nel' ), 3 ); ?></td>
            <td data-filter="round,percent"><%=data.change3YearsPercent.text%></td>
        </tr>
        <tr>
            <td><?php echo sprintf( __( 'Profit %d years', 'nel' ), 5 ); ?></td>
            <td data-filter="round,percent"><%=data.change5YearsPercent.text%></td>
        </tr>
        <tr>
            <td><?php _e( 'Profit this year', 'nel' ); ?></td>
            <td data-filter="round,percent"><%=data.changeYearPercent.text%></td>
        </tr>
    </table>
</script>